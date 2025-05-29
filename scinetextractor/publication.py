"""Class to represent publications."""

import re
import json
import logging
from typing import Any, Self, Dict
import bibtexparser as bp
import bibtexparser.middlewares as bpm
from .utils import config
from .author import Author

# create logger
logger = logging.getLogger("scinetextractor")

# split config file
CONFIG = config["tex"]


def extract_year(string: str) -> str:
    """
    Extract the first occurrence of four consecutive digits from the string.

    :param s: The input string.
    :return: The four-digit number as a string, or None if not found.
    """
    match = re.search(r"\d{4}", string)
    if match:
        return match.group(0)
    return None


def join_strings_with_limit(strings: list, limit: int, delimiter: str = ", ") -> str:
    """Join string items from a list with a fixed limit of items to join.

    Parameters:
        strings (list): The list of strings to join.
        limit (int): The maximum number of items to join.
        delimiter (str): The delimiter to use for joining the strings.

    Returns:
        str: The joined string, considering the limit.
    """
    if not strings:
        return ""
    # Limit the list to the number of items specified by the limit
    limited_strings = strings[:limit]
    # Join the strings with the specified delimiter
    return delimiter.join(limited_strings)


class Publication:
    """Class to store publications."""

    def __init__(self, **kwargs: Any) -> None:
        """Init publication."""
        self._year: int = kwargs.get("year")
        self._title: str = kwargs.get("title")
        self._doi: str = kwargs.get("doi")
        self._bib: str = kwargs.get("bib")
        self._references: Dict[str, Self] = {}
        self._cited: Dict[str, Self] = {}
        self._authors: Dict[str, Author] = {}
        self._data: Dict[str, Any] = kwargs.get("data", dict())
        self._source: str = kwargs.get("source")
        self._keywords = kwargs.get("keywords", None)

        self._linked_data: Dict[str, Any] = {}

        authors = kwargs.get("authors")
        if not authors:
            pass
        elif isinstance(authors, str):
            for author in authors.split("and"):
                new = Author(author)
                self._authors[new.key] = new

        elif isinstance(authors, list) and all(isinstance(a, str) for a in authors):
            for author in authors:
                new = Author(author)
                self._authors[new.key] = new

        elif isinstance(authors, list) and all(isinstance(a, Author) for a in authors):
            for author in authors:
                self._authors[author.key] = author
        else:
            logger.error(f"Author format for <{authors}> cannot be used.")
            raise TypeError

        references = kwargs.get("references")
        if isinstance(references, list):
            self._references = {ref: None for ref in references}
        elif isinstance(references, dict):
            self._references = references

        # self._key: str = self.make_key()

        # assign keyword attritbutes
        self._keywords: list = kwargs.get("keywords", [])

    def __str__(self) -> str:
        """Return description of the publication."""
        string = self.make_key(use_doi=False)
        if self._doi:
            string += " \u2713"
        return string

    def __repr__(self) -> str:
        """Return description of the publication."""
        return f"<{self.key}>"

    def __len__(self) -> int:
        """Return the number of authors."""
        return len(self._authors)

    @property
    def key(self) -> str:
        """Return key of the publication."""
        return self.make_key()

    @property
    def doi(self) -> str:
        """Return doi of the publication."""
        return self._doi

    @property
    def source(self) -> str:
        """Return path to source file."""
        return self._source

    @property
    def year(self) -> int:
        """Return year of the publication."""
        return self._year

    @property
    def data(self) -> Dict[str, Any]:
        """Return data associated with the publication."""
        return self._linked_data | self._data

    @property
    def authors(self) -> Dict[str, Author]:
        """Return a list of authors."""
        return self._authors

    @property
    def references(self) -> Dict[str, Self]:
        """Return a list of referenced papers."""
        return self._references

    @property
    def num_authors(self) -> int:
        """Return number of authors."""
        return len(self._authors)

    def link_data(self) -> None:
        """Link data from external source."""
        if self._source:
            try:
                with open(self._source, "r", encoding="utf-8") as f:
                    self._linked_data = json.load(f)
            except Exception as e:
                logger.warn(f"{self.key} cannot be linked with {self._source}: {e}")

    def set_keywords(self, keywords):
        self._keywords = keywords

    def make_key(
        self, use_doi: bool = True, num_title: int = 3, num_author: int = 1
    ) -> str:
        """Make a unique key for the publication."""
        key: str = ""

        if self._doi and use_doi:
            return self._doi

        if self._authors:
            authors = [a.last.replace(" ", "") for a in self._authors.values()]
            key += join_strings_with_limit(authors, num_author, "")

        if self._year:
            key += str(self._year)

        if self._title:
            # TODO: implement similar function as used in Zotero
            title = self._title.split(" ")
            key += join_strings_with_limit(title, num_title, "_")

        return key

    @property
    def keywords(self) -> list:
        """Return keywords of the publication."""
        return self._keywords

    def to_dict(self) -> dict:
        """Convert Publication to dict."""
        logger.debug(f"Convert <{self.key}> to dict.")
        return {
            "year": self._year,
            "title": self._title,
            "doi": self._doi,
            "authors": list(self.authors.keys()),
            "references": list(self.references.keys()),
            "bib": self._bib,
            "data": self._data,
            "source": self._source,
            "keywords": self._keywords,
        }

    def to_json(self) -> str:
        """Convert Publication to json string."""
        logger.debug(f"Convert <{self.key}> to json.")
        return json.dumps(self.to_dict(), ensure_ascii=False, indent=4)

    @classmethod
    def from_json(cls, json_string: str) -> Self:
        """Create Publication from json entry."""
        data = json.loads(json_string)
        return cls.from_dict(data)

    @classmethod
    def from_dict(cls, data: dict) -> Self:
        """Create Publication from dict."""
        publication = cls(
            year=data.get("year"),
            title=data.get("title"),
            doi=data.get("doi"),
            bib=data.get("bib"),
            authors=data.get("authors"),
            references=data.get("references"),
            data=data.get("data"),
            source=data.get("source"),
            keywords=data.get("keywords"),
        )
        return publication

    @classmethod
    def from_bib(cls, bib_string: str, **kwargs: Any) -> Self:
        """Create Publication from bib entry."""
        # extract entry from bib snipped
        values: dict = cls._parse_bib_string(bib_string)
        return cls(**values, data=kwargs.get("data"))

    @classmethod
    def from_doi(cls, doi_string: str) -> Self:
        """Create Publication from bib entry."""
        return cls()

    @staticmethod
    def _parse_bib_string(bib_string: str) -> dict:
        """Parse bib string to dict."""
        # print(bib_string)
        # TODO: Fix error if no first name is provided (Rossi Residencial LTDA1998)
        # TODO: Fix empty author at the end (Garcia2006)
        # TODO: Last author spitted in two parts (Brandalise2021)
        # TODO: Missing first name (Mardiansyah2024)
        try:
            entry = bp.parse_string(
                bib_string,
                append_middleware=[bpm.SeparateCoAuthors(), bpm.SplitNameParts()],
            ).entries[0]
        except IndexError:
            logger.error(f"Authors note complete in {bib_string}")
            raise IndexError

        # Create author classes based on bibtex entry
        try:
            authors = [Author(author.first, author.last) for author in entry["author"]]
        except KeyError:
            logging.warn(f"Author for {entry.key} is not defined.")
            authors = [Author("None, None")]

        # TODO: extract year from date filed if given from biblatex
        if entry.get("year"):
            year = int(entry.get("year").value)
        elif entry.get("date"):
            date = extract_year(entry.get("date").value)
            year = int(date) if date else None
        else:
            year = None
        if not year:
            logging.warn(f"Year for {entry.key} is not defined.")
            # raise KeyError
            year = 0

        # TODO: clean title
        title = entry.get("title").value if entry.get("title") else "No Title Provided"
        title = title.replace("{", "").replace("}", "")

        # TODO: clean doi
        doi = entry.get("doi").value if entry.get("doi") else None

        # Extract keywords
        keywords = (
            entry.get("author_keywords").value if entry.get("author_keywords") else ""
        )
        keywords = [kw.strip() for kw in keywords.split(",")] if keywords else []

        return {
            "year": year,
            "title": title,
            "doi": doi,
            "bib": entry.raw,
            "authors": authors,
            "keywords": keywords,
        }
