"""mto_client.py

A module that provides a client and associated parsing methods
for extracting data from Music Theory Online (MTO) web pages.
"""

import re
import requests
import unicodedata
from bs4 import BeautifulSoup
from markdownify import markdownify
import os
import json
from urllib.parse import urlparse


class MTOClient:
    """MTO Parser class.

    A client for fetching and parsing Music Theory Online (MTO) content.
    The client stores the latest fetched HTML as well as parsed data
    directly in instance attributes.
    """

    def __init__(self):
        """Initiate MTO client."""
        self.current_html = None

        # Parsed data attributes.
        self.issues_data = []
        self.section_links = []
        self.metadata = {}
        self.authors = []
        self.article_abstract = {}
        self.works_cited = {}
        self.footnotes = {}
        self.markdown_body = ""
        self.article_body = []

    def fetch(self, url: str) -> str:
        """Fetch data online.

        Fetch the raw HTML from a given URL and store it in the instance.
        :param url: The webpage URL from which HTML should be fetched.
        :return: The page HTML as a string, or None if there is an error.
        """
        try:
            response = requests.get(url)
            response.raise_for_status()
            self.current_html = response.text
            return self.current_html
        except requests.exceptions.RequestException as e:
            print(f"Error fetching {url}: {e}")
            self.current_html = None
            return None

    def load(self, filepath: str) -> str:
        """Load data from file.

        Load HTML content from a local file and store it in the instance.
        :param filepath: The path to the HTML file.
        :return: The file content as a string, or None if there is an error.
        """
        try:
            with open(filepath, "r", encoding="utf-8") as f:
                self.current_html = f.read()
            print(f"HTML successfully loaded from {filepath}")
            return self.current_html
        except Exception as e:
            print(f"Error loading HTML from file {filepath}: {e}")
            self.current_html = None
            return None

    def parse_article_metadata(self, html: str = None) -> dict:
        """Parse metadata.

        Extract key publication metadata from an MTO article HTML.
        Stores the metadata in self.metadata.
        """
        html = html or self.current_html
        if not html:
            self.metadata = {}
            return {}

        soup = BeautifulSoup(html, "html.parser")
        metadata = {"title": "", "date": "", "volume": "", "issue": "", "authors": []}

        for meta in soup.find_all("meta"):
            name = meta.get("name", "").lower().strip()
            content = meta.get("content", "").strip()
            if name == "citation_title":
                metadata["title"] = unicodedata.normalize("NFKD", content)
            elif name == "citation_publication_date":
                metadata["date"] = content
            elif name == "citation_volume":
                metadata["volume"] = content
            elif name == "citation_issue":
                metadata["issue"] = content
            elif name == "citation_author":
                metadata["authors"].append(content)

        self.metadata = metadata
        return metadata

    def parse_author_info(self, html: str = None) -> list:
        """Parse Authors.

        Parse MTO-style author notes (<a name="AUTHORNOTE...">) and store the list of author
        dicts in self.authors.
        Each dict contains: "name", "university", "address", "email".
        """
        html = html or self.current_html
        if not html:
            self.authors = []
            return []

        soup = BeautifulSoup(html, "html.parser")
        anchors = soup.find_all("a", attrs={"name": re.compile(r"AUTHORNOTE\d+")})
        authors_info = []

        def _gather_text_until_next_anchor(start, next_anchor):
            lines = []
            temp_chunks = []
            for sibling in start.next_siblings:
                if sibling == next_anchor:
                    break
                if (
                    sibling.name == "a"
                    and sibling.has_attr("name")
                    and re.match(r"AUTHORNOTE\d+", sibling["name"])
                ):
                    break
                if sibling.name == "br":
                    line = "".join(temp_chunks).strip()
                    if line:
                        lines.append(line)
                    temp_chunks = []
                elif (
                    sibling.name == "a"
                    and sibling.has_attr("href")
                    and sibling["href"].startswith("mailto:")
                ):
                    email = sibling["href"].replace("mailto:", "").strip()
                    temp_chunks.append(email)
                else:
                    text_part = (
                        sibling.get_text(" ", strip=False)
                        if hasattr(sibling, "get_text")
                        else str(sibling)
                    )
                    temp_chunks.append(text_part.replace("\n", " "))
            leftover = "".join(temp_chunks).strip()
            if leftover:
                lines.append(leftover)
            return [ln.strip() for ln in lines if ln.strip()]

        for i, anchor in enumerate(anchors):
            next_anchor = anchors[i + 1] if i + 1 < len(anchors) else None
            lines = _gather_text_until_next_anchor(anchor, next_anchor)
            if not lines:
                continue

            name = lines[0] if len(lines) > 0 else ""
            university = lines[1] if len(lines) > 1 else ""
            address = ""
            email = ""

            if len(lines) > 2:
                last_line = lines[-1]
                if "@" in last_line:
                    email = last_line
                    address_parts = lines[2:-1]
                else:
                    address_parts = lines[2:]
                address = ", ".join(address_parts)

            authors_info.append(
                {
                    "name": name.strip(),
                    "university": university.strip(),
                    "address": address.strip(),
                    "email": email.strip(),
                }
            )
        self.authors = authors_info
        return authors_info

    def parse_article_abstract(self, html: str = None) -> dict:
        """Parse Abstract.

        Parse an MTO article for its abstract, keywords, DOI, received date, and PDF link.
        Stores the result in self.article_abstract.
        """
        html = html or self.current_html
        if not html:
            self.article_abstract = {}
            return {}

        soup = BeautifulSoup(html, "html.parser")
        data = {"abstract": "", "keywords": [], "doi": "", "received": "", "pdf": ""}

        # KEYWORDS
        keywords_tag = soup.find(
            lambda t: t.name == "p" and "KEYWORDS:" in t.get_text().upper()
        )
        if keywords_tag:
            text = keywords_tag.get_text(strip=True)
            idx = text.upper().find("KEYWORDS:")
            if idx != -1:
                keywords_str = text[idx + len("KEYWORDS:") :].strip()
                keywords_str = re.sub(r"\s+", " ", keywords_str)
                data["keywords"] = [kw.strip() for kw in keywords_str.split(",")]

        # ABSTRACT
        abstract_tag = soup.find(
            lambda t: t.name == "p" and "ABSTRACT:" in t.get_text().upper()
        )
        if abstract_tag:
            text = abstract_tag.get_text(strip=True)
            idx = text.upper().find("ABSTRACT:")
            if idx != -1:
                abs_str = text[idx + len("ABSTRACT:") :].strip()
                data["abstract"] = re.sub(r"\s+", " ", abs_str)

        # DOI
        doi_tag = soup.find(
            lambda t: t.name == "small" and "DOI:" in t.get_text().upper()
        )
        if doi_tag:
            text = doi_tag.get_text(strip=True)
            idx = text.upper().find("DOI:")
            if idx != -1:
                data["doi"] = text[idx + len("DOI:") :].strip()

        # RECEIVED DATE
        received_tag = soup.find(
            lambda t: t.name == "i" and "RECEIVED" in t.get_text().upper()
        )
        if received_tag:
            text = received_tag.get_text(strip=True)
            idx = text.upper().find("RECEIVED")
            if idx != -1:
                data["received"] = text[idx + len("RECEIVED") :].strip()

        # PDF LINK
        for link in soup.find_all("a", href=True):
            if link.get_text(strip=True).lower().startswith("pdf text"):
                data["pdf"] = link["href"].strip()
                break

        self.article_abstract = data
        return data

    def parse_citations(self, html: str = None) -> dict:
        """Parse Citations.

        Parse the "Works Cited" section from an MTO article.
        Stores the result in self.works_cited.
        """
        html = html or self.current_html
        if not html:
            self.works_cited = {}
            return {}

        soup = BeautifulSoup(html, "html.parser")
        works_cited = {}

        for h3 in soup.find_all("h3"):
            anchor = h3.find("a", attrs={"name": "WorksCited"})
            if anchor:
                for element in h3.next_elements:
                    if element.name == "h3" and element is not h3:
                        break
                    if element.name == "div" and element.has_attr("id"):
                        div_id = element["id"]
                        if div_id.startswith("citediv_"):
                            works_cited[div_id.replace("citediv_", "")] = (
                                element.get_text(" ", strip=True)
                            )
        self.works_cited = works_cited
        return works_cited

    def parse_footnotes(self, html: str = None) -> dict:
        """Parse Footnotes.

        Parse the "Footnotes" section from an MTO article.
        Stores the result in self.footnotes.
        """
        html = html or self.current_html
        if not html:
            self.footnotes = {}
            return {}

        soup = BeautifulSoup(html, "html.parser")
        footnotes = {}
        # Pattern to match keys like FN1, FM2, etc.
        key_pattern = re.compile(r"^(FN|FM)\d+$")

        for h3 in soup.find_all("h3"):
            if h3.find("a", attrs={"name": "Footnotes"}):
                for sibling in h3.next_siblings:
                    if not hasattr(sibling, "name"):
                        continue
                    if sibling.name in ["h3", "hr"]:
                        break
                    if sibling.name == "p":
                        footnote_anchor = sibling.find("a", attrs={"name": key_pattern})
                        if footnote_anchor:
                            key = footnote_anchor["name"]
                            for a in sibling.find_all("a"):
                                if "return to text" in a.get_text(strip=True).lower():
                                    a.decompose()
                            note_text = sibling.get_text(" ", strip=True)
                            footnotes[key] = {
                                "text": note_text,
                                "citations": self.extract_referenced_citations(
                                    str(sibling)
                                ),
                            }
        self.footnotes = footnotes
        return footnotes

    def parse_markdown_body(self, html: str = None) -> str:
        """Parse body in markdown format (NOT NEEDED).

        Extract all HTML between "ARTICLE BODY (begin)" and "END Article Body",
        then convert that snippet to Markdown using markdownify.
        Stores the markdown result in self.markdown_body.
        """
        html = html or self.current_html
        if not html:
            self.markdown_body = ""
            return ""

        start_marker = "ARTICLE BODY (begin)"
        end_marker = "END Article Body"

        start_idx = html.find(start_marker)
        end_idx = html.find(end_marker)
        if start_idx == -1 or end_idx == -1:
            self.markdown_body = ""
            return ""

        snippet = html[start_idx + len(start_marker) : end_idx]
        self.markdown_body = markdownify(snippet)
        return self.markdown_body

    def extract_body_html(self, html: str = None) -> str:
        """Extract body from html.

        Finds the article body text using markers in HTML comments.
        Returns the substring (raw HTML) between the markers.
        """
        html = html or self.current_html
        if not html:
            return ""

        pattern = re.compile(
            r"(?is)"
            r"<!--+\s*ARTICLE BODY\s*\(begin\).*?-->(.*?)<!--+\s*END\s+Article\s+Body.*?-->",
            re.DOTALL,
        )

        match = pattern.search(html)
        if match:
            return match.group(1)
        return ""

    def extract_referenced_footnotes(self, html: str = None) -> list:
        """Extract Footnotes.

        Extract from an HTML snippet the referenced footnotes.
        It searches for <a> tags with an href attribute that starts with "#FN"
        and returns a list of footnote ids (e.g. ["FN3", "FN4"]).

        :param html: The HTML snippet as a string. If None, self.current_html is used.
        :return: A list of referenced footnote IDs.
        """
        html = html or self.current_html
        if not html:
            self.referenced_footnotes = []
            return []

        soup = BeautifulSoup(html, "html.parser")
        footnote_ids = []
        for a in soup.find_all("a", href=True):
            href = a["href"]
            if href.startswith("#FN"):
                # Remove the leading '#' to get the footnote id
                footnote_id = href[1:]
                footnote_ids.append(footnote_id)
        self.referenced_footnotes = footnote_ids
        return footnote_ids

    def extract_referenced_citations(self, html: str = None) -> list:
        """Extract Citations.

        Extract citation keys from an HTML snippet.
        The method searches for <a> tags with an id attribute matching a pattern like:
          citation_ledbetter_2002_67db2b3f74f5d
        and returns the citation key (e.g. "ledbetter_2002").

        :param html: The HTML snippet as a string. If None, self.current_html is used.
        :return: A list of citation keys.
        """
        html = html or self.current_html
        if not html:
            self.citations = []
            return []

        soup = BeautifulSoup(html, "html.parser")
        citation_keys = []
        # This regex looks for id attributes starting with "citation_"
        # followed by the citation key and then an underscore with a trailing hexadecimal string.
        pattern = re.compile(r"^citation_([a-zA-Z0-9_]+?)_(?:[a-f0-9]+)$")
        for a in soup.find_all("a", id=True):
            id_val = a.get("id", "")
            match = pattern.match(id_val)
            if match:
                citation_keys.append(match.group(1))
        self.citations = citation_keys
        return citation_keys

    def parse_article_body(self, html: str = None) -> list:
        """Parse article text.

        Extract a single article body from HTML.
        Stores the result in self.article_body.
        """
        html = html or self.current_html
        raw_body_html = self.extract_body_html(html)

        soup = BeautifulSoup(raw_body_html, "html.parser")
        splitted = re.split(r"(<p>\s*\[\d+(?:\.\d+)?\])", str(soup))
        bracket_re = re.compile(r"(<p>\s*\[\d+(?:\.\d+)?\])")
        pattern = re.compile(r"^<p>\[([0-9]+(?:\.[0-9]+)?)\]$")

        body = []
        for i in range(1, len(splitted)):
            match = bracket_re.match(splitted[i - 1])
            label = ""
            if match:
                label = re.sub(r"\s+", "", splitted[i - 1])
                m = pattern.match(label)
                key = m.group(1) if m else None
                html = label + splitted[i]
                text = BeautifulSoup(html, "html.parser").get_text(" ", strip=True)

                body.append(
                    {
                        key: {
                            "text": text,
                            "footnotes": self.extract_referenced_footnotes(html),
                            "citations": self.extract_referenced_citations(html),
                        }
                    }
                )
            elif i == 1:
                html = splitted[i - 1]
                text = BeautifulSoup(html, "html.parser").get_text(" ", strip=True)
                body.append(
                    {
                        "0": {
                            "text": text,
                            "footnotes": self.extract_referenced_footnotes(html),
                            "citations": self.extract_referenced_citations(html),
                        }
                    }
                )

        self.article_body = body
        return body

    def get_article_data(self, source: str) -> dict:
        """Get article data.

        Convenience method to fetch and parse an MTO article.  If the provided
        source is a URL (starting with "http"), it fetches the data from the
        internet.  Otherwise, it treats the source as a local file path and
        loads the data accordingly.

        After loading, the parsed metadata, authors, abstract, works cited,
        and footnotes are stored in the instance.

        :param source: The article URL or local file path.
        :return: A dict with the parsed data.

        """
        # Strip any leading/trailing whitespace.
        source = source.strip()

        # Detect whether source is a URL or a file path.
        if source.lower().startswith("http"):
            html = self.fetch(source)
        else:
            html = self.load(source)

        if not html:
            return {}

        data = {}
        data.update(self.parse_article_metadata(html))
        data.update(self.parse_article_abstract(html))
        data["author_info"] = self.parse_author_info(html)
        data["citations"] = self.parse_citations(html)
        data["footnotes"] = self.parse_footnotes(html)
        data["paragraphs"] = self.parse_article_body(html)

        # fix no authors:
        if not data["authors"]:
            data["authors"] = [a["name"] for a in data["author_info"]]

        return data

    def to_json(self, source: str, output_dir: str, **kwargs):
        """
        Save the article data to a JSON file.

        This method adds two extra fields to the data dictionary:
        - raw_html_link: set to the source if it is a URL, else None.
        - file_location: set to the source if it is a file path, else None.

        The JSON file name is derived from the HTML file name by replacing the .html
        extension with .json. The file is saved in the provided output_dir.

        :param data: The dictionary containing parsed article data.
        :param source: The article source, either a URL or a local file path.
        :param output_dir: The directory where the JSON file should be saved.
        """
        # gest data
        data = self.get_article_data(source)

        if kwargs:
            data.update(kwargs)

        # Determine if source is a URL or a file path.
        is_url = True if source.lower().startswith("http") else False

        # Add source information to the data dictionary.
        data["source"] = source

        # Get the base file name.
        if is_url:
            base_name = os.path.basename(urlparse(source).path)
        else:
            base_name = os.path.basename(source)

        # Replace .html extension with .json (if .html not found, append .json).
        name_without_ext, ext = os.path.splitext(base_name)
        json_file_name = f"{name_without_ext}.json"

        # Ensure the output directory exists.
        if not os.path.exists(output_dir):
            os.makedirs(output_dir, exist_ok=True)

        output_path = os.path.join(output_dir, json_file_name)

        data["data"] = output_path

        try:
            with open(output_path, "w", encoding="utf-8") as json_file:
                json.dump(data, json_file, indent=4, ensure_ascii=False)
            print(f"Data successfully saved to {output_path}")
        except Exception as e:
            print(f"Error saving JSON to {output_path}: {e}")


def main():
    """Use the MTOClient."""
    # with open("issues_data.json", "r", encoding="utf-8") as f:
    #     issues = json.load(f)

    # fixed_keys = {"url", "volume", "number", "date"}
    # for issue in issues:
    #     for key, links in issue.items():
    #         if key in fixed_keys:
    #             continue
    #         print(key)

    # path = "raw/mto.23.29.4.braunschweig.html"
    # client = MTOClient()
    # # client.load(path)

    # # data = client.get_article_data(path)
    # client.to_json(path, "mto", mto=True)


if __name__ == "__main__":
    main()
