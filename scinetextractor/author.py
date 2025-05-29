"""Class to represent authors."""

import json
import logging
from typing import Any, Self, Dict, Union, List, Tuple, Set
import bibtexparser as bp

from .utils import config
from .utils import extract_orcids
from .utils import extract_emails
# from .nlp import extract_locations

# create logger
logger = logging.getLogger("scinetextractor")

# split config file
CONFIG = config["tex"]


def parse_name(*name: Union[str, list]) -> Tuple[List, List]:
    """Parse Author Name and return dict with first and last name."""
    # if string is given
    first = []
    last = []
    if len(name) == 1 and isinstance(name[0], str):
        if "," in name[0]:
            value = [part.strip() for part in name[0].strip().split(",")]
            last.extend(value[0].split(" "))
            first.extend(value[1].split(" "))
        else:
            value = [part.strip() for part in name[0].strip().split(" ")]
            last.append(value[-1])
            first.extend(value[:-1])
    elif len(name) >= 1 and isinstance(name[0], list):
        first.extend(name[0])
        last.extend(name[1])
    else:
        logger.error(f"Currently <{name}> cannot be parsed!")
        raise NotImplementedError

    return first, last


class Author:
    """Class to store publications."""

    def __init__(self, *args: Union[str, list], **kwargs: Any) -> None:
        """Init publication."""
        self._first, self._last = parse_name(*args)
        self._orcid: str = kwargs.get("orcid", None)
        self._publications: Dict[str, Any] = {}
        self._collaborators: Dict[str, Self] = {}
        self._affiliations: Dict[str, str] = {}
        self._aliases: Set[str] = kwargs.get("aliases", set())
        self._aliases.add(self.name)
        self._data: Dict[str, Any] = kwargs.get("data", dict())

    def __str__(self) -> str:
        """Return name of the author."""
        return f"{self.name}"

    def __repr__(self) -> str:
        """Return name of the author."""
        return f"<{self.name}>"

    def __len__(self) -> int:
        """Return the number of publications."""
        return len(self._publications)

    @property
    def name(self) -> str:
        """Return name of the Author."""
        return f"{' '.join(self._last)}, {' '.join(self._first)}"

    @property
    def key(self) -> str:
        """Return a (hopefully) unique key for the Author."""
        return f"{' '.join(self._last)}, {' '.join(self._first)}"

    @property
    def aliases(self) -> set:
        """Return aliases of the Author."""
        return self._aliases

    @property
    def orcid(self) -> str:
        """Return Author's orcid."""
        return self._orcid

    @orcid.setter
    def orcid(self, value: str) -> None:
        """Set Author's orcid."""
        if not self._orcid and isinstance(value, str):
            self._orcid = value
        elif self._orcid != value:
            logger.error(f"Authro's orcid <{self.orcid}> does not  match with {value}!")
            raise KeyError

    @property
    def last(self) -> str:
        """Return the last name of the Author."""
        return f"{' '.join(self._last)}"

    @property
    def first(self) -> str:
        """Return the first name of the Author."""
        return f"{' '.join(self._first)}"

    @property
    def data(self) -> Dict[str, Any]:
        """Return data associated with the author."""
        return self._data

    @property
    def publications(self) -> Dict[str, Any]:
        """Return publications of the author."""
        return self._publications

    @property
    def collaborators(self) -> Dict[str, Self]:
        """Return collaborators of the author."""
        return self._collaborators

    def update(self, other: Self) -> None:
        """Update Author form other Author."""
        # check orcids
        if other.orcid and not self.orcid:
            self._orcid = other.orcid
        elif self.orcid and other.orcid and self.orcid != other.orcid:
            logger.error(f"Orcids for <{self}> and <{other}> are not matching!")
            raise KeyError

        key_old = self.key
        key_new = other.key

        # update variables
        self._aliases = self.aliases.union(other.aliases)
        self.data.update(other.data)
        self.publications.update(other.publications)
        self.collaborators.update(other.collaborators)
        self._first = other._first
        self._last = other._last

        # finish update if key has not changed
        if key_old == key_new:
            return None

        # update linked publications
        for publication in list(self.publications.values()):
            for key, author in list(publication.authors.items()):
                if key == key_old:
                    publication.authors[self.key] = publication.authors.pop(key_old)
                else:
                    publication.authors[key] = publication.authors.pop(key)

        # update linked collaborators
        for key, collaborator in list(self.collaborators.items()):
            if key_old in collaborator.collaborators:
                collaborator.collaborators[self.key] = collaborator.collaborators.pop(
                    key_old
                )

        # Update key values
        for key, publication in list(self.publications.items()):
            if key != publication.key:
                self.publications[publication.key] = self.publications.pop(key)
                for author in publication.authors.values():
                    if author != self:
                        author.publications[publication.key] = author.publications.pop(
                            key
                        )

    def add_publication(self, publication) -> None:
        """Assign publication to the Author."""
        if publication.key not in self._publications:
            self.publications[publication.key] = publication
            for key, author in publication.authors.items():
                if key != self.key and key not in self.collaborators:
                    self.collaborators[key] = author

    def extract_orcid(self) -> None:
        """Extract orcids from the authors."""
        logger.debug(f"Extract orcid for {self.name}")
        raise NotImplementedError

    def extract_affiliations(self) -> None:
        """Extract affiliation from publication."""
        logger.debug(f"Extract affiliations for {self.name}")

        data: dict = {}
        for key, publication in self.publications.items():
            # Check bibtex affilation (if given)
            value = bp.parse_string(publication._bib).entries[0].get("affiliation")
            if value and not value.value.isspace():
                affiliations = value.value.split(";")
                position = self.get_author_position(key)
                self._affiliations[key] = affiliations[position]

                # Extract information from affiliation
                affiliation = affiliations[position]

                # Extract orcid from affiliation text
                orcids = extract_orcids(affiliation)
                if orcids:
                    if len(orcids) > 1:
                        logger.error(f"Author {self.name} has multiple orcids")
                        raise KeyError
                    else:
                        orcid = orcids[0]
                    if not self.orcid:
                        self._orcid = orcid
                    elif self.orcid != orcid:
                        logger.error(
                            {
                                f"Authro's orcid <{self.orcid}> does not  match with {orcid}!"
                            }
                        )
                        raise KeyError

                # Extract email from affiliation
                emails = extract_emails(affiliation)
                if emails:
                    data["email"] = emails[0]

                # # Extract locations:
                # locations = extract_locations(affiliation)
                # if locations:
                #     if locations["countries"]:
                #         data["country"] = locations["countries"]
                #     if locations["cities"]:
                #         data["city"] = locations["cities"]

                # Extract position:
                # print(affiliation)
            # print(data)

    def get_author_position(self, key: str) -> int:
        """Get the author position in the paper."""
        position: int = 0
        if key in self.publications:
            for i, author in enumerate(self.publications[key].authors.values()):
                if author == self:
                    position = i
                    break
        else:
            logger.error(f"Author {self.name} has no publication with key <{key}>")
            raise KeyError

        return position

    # def compare(self, other: Self) -> bool:
    #     """Compare with an other author and return True if same."""
    #     is_same = False

    #     return is_same

    def to_json(self) -> str:
        """Convert Author to json string."""
        logger.debug(f"Convert <{self.name}> to json.")
        return json.dumps(self.to_dict(), ensure_ascii=False, indent=4)

    def to_dict(self) -> dict:
        """Convert Author to dict."""
        logger.debug(f"Convert <{self.name}> to dict.")
        return {
            "first": self._first,
            "last": self._last,
            "orcid": self.orcid,
            "publications": list(self.publications.keys()),
            "collaborators": list(self.collaborators.keys()),
            "aliases": list(self.aliases),
            "data": self.data,
        }

    @classmethod
    def from_bib(cls, bib_string: str) -> Self:
        """Create Author from bib entry."""
        return cls()

    @classmethod
    def from_orcid(cls, orcid_string: str) -> Self:
        """Create Author from orcid entry."""
        return cls()

    @classmethod
    def from_json(cls, json_string: str) -> Self:
        """Create Author from json entry."""
        data = json.loads(json_string)
        return cls.from_dict(data)

    @classmethod
    def from_dict(cls, data: dict) -> Self:
        """Create Author from dict."""
        author = cls(
            data["first"],
            data["last"],
            orcid=data.get("orcid"),
            aliases=set(data.get("aliases")) if data.get("aliases") else set(),
            data=data.get("data"),
            keywords=data.get("keywords"),
        )
        return author
