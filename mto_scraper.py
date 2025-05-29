"""mto_scraper.py"""

import os
import re
import json
import requests
from bs4 import BeautifulSoup


class MTOScraper:
    """
    A scraper class for extracting journal volume/issue data and downloading associated article pages.

    It performs the following tasks:
      - Scrapes the issues page for volume/issue details.
      - Extracts categorized article links from each issue page.
      - Saves the scraped issues data to a JSON file.
      - Downloads each article page while tracking download status.
    """

    def __init__(
        self,
        issues_page_url: str,
        prefix: str = "",
        tracker_filename: str = "download_tracker.json",
        download_folder: str = "raw",
    ):
        """
        Initialize the scraper.

        :param issues_page_url: URL of the journal's issues listing page.
        :param prefix: URL prefix to prepend to relative issue URLs.
        :param tracker_filename: Filename for storing download status.
        :param download_folder: Folder where downloaded HTML files will be saved.
        """
        self.issues_page_url = issues_page_url
        self.prefix = prefix
        self.tracker_filename = tracker_filename
        self.download_folder = download_folder
        self.issues_data = []  # Will hold dictionaries for each issue.

    # --------------------
    # Scraping Methods
    # --------------------

    def fetch(self, url: str) -> str:
        """
        Fetch the raw HTML from the given URL.

        :param url: The webpage URL.
        :return: The HTML content as a string, or None on error.
        """
        try:
            response = requests.get(url)
            response.raise_for_status()
            return response.text
        except requests.exceptions.RequestException as e:
            print(f"Error fetching {url}: {e}")
            return None

    def extract_volume_issue_data(self, html: str) -> list:
        """
        Extract volume and issue information from the issues page HTML.

        This function finds issue URLs matching a pattern (e.g., 'mto.24.30.4/toc.30.4.html') and
        extracts volume, number, and date information from surrounding text.

        :param html: The HTML content of the issues page.
        :return: A list of dictionaries containing issue data.
        """
        soup = BeautifulSoup(html, "html.parser")
        url_pattern = re.compile(r"mto\.\d+\.\d+\.\d+/toc\.\d+\.\d+\.html")
        volnum_pattern = re.compile(
            r"Volume\s+(\d+),\s+Number\s+(\d+),\s+([A-Za-z]+\s+\d{4})"
        )

        results = []
        for link in soup.find_all("a", href=True):
            href = link["href"].strip()
            if url_pattern.search(href):
                line_text = link.parent.get_text(" ", strip=True)
                match = volnum_pattern.search(line_text)
                if match:
                    issue_data = {
                        "url": self.prefix + href,
                        "volume": match.group(1),
                        "number": match.group(2),
                        "date": match.group(3),
                    }
                    results.append(issue_data)
        self.issues_data = results
        return results

    def extract_section_links(self, html_text: str) -> dict:
        """
        Extract categorized article links from an issue page.

        For every <h3> tag (marking a section heading such as "Articles",
        "Reviews", "Essay", etc.), this method collects all subsequent <a> tag links until the next <h3>
        is reached. Links with the text "Commentary" are skipped, and only those with a valid
        URL pattern are included.

        :param html_text: The raw HTML as a string.
        :return: A dictionary mapping section names (in lowercase) to lists of link URLs.
        """
        soup = BeautifulSoup(html_text, "html.parser")
        sections = {}
        for h3 in soup.find_all("h3"):
            category = h3.get_text(strip=True)
            if category.lower() == "commentary":
                continue
            cat_key = category.lower()
            if cat_key not in sections:
                sections[cat_key] = []
            for elem in h3.next_elements:
                if elem.name == "h3":
                    break
                if elem.name == "a" and elem.has_attr("href"):
                    link_text = elem.get_text(strip=True)
                    if link_text.lower() == "commentary":
                        continue
                    href = elem["href"]
                    # Only include links that contain the expected pattern.
                    if ".org/issues/mto." not in href:
                        continue
                    sections[cat_key].append(href)
        return sections

    def extract_links_for_issue(self, issue_url: str) -> dict:
        """
        Fetch and extract all categorized links for a given issue.

        :param issue_url: The URL of the issue page.
        :return: A dictionary mapping category names to lists of links.
        """
        html = self.fetch(issue_url)
        if html:
            return self.extract_section_links(html)
        return {}

    def extract_articles_for_all_issues(self):
        """
        For every issue stored in self.issues_data, fetch its page and extract categorized links.

        Each issue dictionary is updated with new keys for each category (e.g., "articles", "reviews").
        """
        total = len(self.issues_data)
        for i, issue in enumerate(self.issues_data, start=1):
            issue_url = issue.get("url")
            if not issue_url:
                continue
            print(
                f"Processing issue {i}/{total} (Volume {issue.get('volume')}, Number {issue.get('number')})"
            )
            sections = self.extract_links_for_issue(issue_url)
            for category, links in sections.items():
                issue[category] = links

    def scrape(self, filename: str = None) -> list:
        """
        Run the complete scraping process: fetch the issues page, extract issue data,
        and for each issue extract categorized article links.

        :return: A list of dictionaries (one per issue) with the scraped data.
        """
        issues_html = self.fetch(self.issues_page_url)
        if issues_html is None:
            return []
        self.extract_volume_issue_data(issues_html)
        self.extract_articles_for_all_issues()

        if filename:
            self.save_issues_data(filename)

        return self.issues_data

    def save_issues_data(self, filename: str):
        """
        Save the scraped issues data to a JSON file.

        :param filename: The file path where the data will be saved.
        """
        try:
            with open(filename, "w", encoding="utf-8") as f:
                json.dump(self.issues_data, f, ensure_ascii=False, indent=4)
            print(f"Issues data saved to {filename}")
        except Exception as e:
            print(f"Error saving issues data: {e}")

    def load_issues_data(self, filename: str):
        """
        Load issues data from a JSON file into self.issues_data.

        :param filename: The path to the JSON file.
        :return: The loaded issues data, or None if an error occurs.
        """
        try:
            with open(filename, "r", encoding="utf-8") as f:
                self.issues_data = json.load(f)
            return self.issues_data
        except Exception as e:
            print(f"Error loading issues data: {e}")
            return None

    # --------------------
    # Download Methods
    # --------------------

    def _load_download_status(self) -> dict:
        """
        Load the download tracker from a JSON file.

        :return: A dictionary mapping links to their download status.
        """
        if os.path.exists(self.tracker_filename):
            try:
                with open(self.tracker_filename, "r", encoding="utf-8") as f:
                    status = json.load(f)
                return status
            except Exception as e:
                print(f"Error loading tracker file: {e}")
        return {}

    def _save_download_status(self, status: dict):
        """
        Save the download tracker dictionary to a JSON file.

        :param status: The dictionary mapping links to download status.
        """
        try:
            with open(self.tracker_filename, "w", encoding="utf-8") as f:
                json.dump(status, f, ensure_ascii=False, indent=4)
        except Exception as e:
            print(f"Error saving tracker file: {e}")

    def download_links(self, links: list):
        """
        Download the HTML content for each link in the list and save it as an HTML file.

        This method uses a tracker file to skip links that have already been downloaded.

        :param links: List of URL strings to download.
        """
        # Ensure the download folder exists.
        if not os.path.exists(self.download_folder):
            os.makedirs(self.download_folder)

        tracker = self._load_download_status()
        total = len(links)
        processed = 0

        for i, link in enumerate(links, start=1):
            # Skip already downloaded links.
            if tracker.get(link, {}).get("status") == "downloaded":
                print(f"[{i}/{total}] Already downloaded: {link}")
                processed += 1
                continue

            # Generate a safe filename from the URL.
            filename = os.path.basename(link.split("?")[0])
            file_path = os.path.join(self.download_folder, filename)

            # If file exists, mark as downloaded.
            if os.path.exists(file_path):
                print(f"[{i}/{total}] File exists: {filename}")
                tracker[link] = {"status": "downloaded", "filename": filename}
                processed += 1
                self._save_download_status(tracker)
                continue

            try:
                print(f"[{i}/{total}] Downloading: {link}")
                response = requests.get(link)
                response.raise_for_status()
                with open(file_path, "w", encoding="utf-8") as f:
                    f.write(response.text)
                tracker[link] = {"status": "downloaded", "filename": filename}
                processed += 1
                print(f"[{i}/{total}] Downloaded: {filename}")
            except Exception as e:
                print(f"[{i}/{total}] Failed to download {link}: {e}")
                tracker[link] = {"status": "failed", "error": str(e)}
            self._save_download_status(tracker)

        print(f"Finished: {processed} out of {total} websites processed.")

    def create_link_list(self) -> list:
        """
        Extract a flat list of article links from all issues data.

        It ignores fixed keys like "url", "volume", "number", and "date".

        :return: A list of URL strings.
        """
        link_list = []
        fixed_keys = {"url", "volume", "number", "date"}
        for issue in self.issues_data:
            for key, links in issue.items():
                if key in fixed_keys:
                    continue
                if isinstance(links, list):
                    link_list.extend(links)
        return link_list

    def download_all_articles(self):
        """
        Extract all article links from the scraped issues data and download them.
        """
        links = self.create_link_list()
        print(f"Total links extracted: {len(links)}")
        self.download_links(links)


# --------------------
# Main Execution Block
# --------------------
def main():
    """Run MTOScraper."""
    # issues_page_url = "https://www.mtosmt.org/issues/issues.php"
    # prefix = "https://mtosmt.org/issues/"

    # scraper = MTOScraper(issues_page_url, prefix)

    # print("Starting scraping process...")
    # scraper.scrape(filename="issues.json")

    # # Optional: Download all article pages.
    # print("Starting download process...")
    # scraper.download_all_articles()


if __name__ == "__main__":
    main()
