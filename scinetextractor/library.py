"""Class to collect publications and authors."""

import csv
import json
import logging
import itertools
import bibtexparser as bp
from typing import Any, Dict, Self, List, Tuple, Set
from collections import defaultdict
from difflib import SequenceMatcher
from .utils import config
from .publication import Publication
from .author import Author


# create logger
logger = logging.getLogger("scinetextractor")

# split config file
CONFIG = config["tex"]


def similarity(str_a: str, str_b: str) -> float:
    """Compare similarity between two strings."""
    return SequenceMatcher(None, str_a, str_b).ratio()


def window(sequence, size=3):
    """Slide over list."""
    size = min(len(sequence), size)
    sequence.sort()
    compare = set()
    for i in range(len(sequence) - size + 1):
        for tup in itertools.combinations(sequence[i : i + size], 2):
            compare.add(tup)

    return compare


class Library:
    """Class to store publications and authors."""

    def __init__(self, **kwargs: Any) -> None:
        """Init publication."""
        self._publications: Dict[str, Publication] = {}
        self._authors: Dict[str, Author] = {}
        self._filename: str = kwargs.get("filename", config["library"]["filename"])
        self._check: bool = kwargs.get("check", False)

    def __str__(self) -> str:
        """Return description of the publication."""
        return f"Publications: {len(self.publications)}, Authors: {len(self.authors)}"

    @property
    def authors(self) -> Dict[str, Author]:
        """Return dictionary of authors."""
        return self._authors

    @property
    def publications(self) -> Dict[str, Publication]:
        """Return dictionary of publications."""
        return self._publications

    def get_aliases(self, inverse: bool = True) -> Dict:
        """Get aliases of authors as a map."""
        # aliases = {key: author.aliases for key, author in self.authors.items()}
        aliases = {}
        for key, author in self.authors.items():
            if inverse:
                for alias in author.aliases:
                    aliases[alias] = key
            else:
                aliases[key] = author.aliases
        return aliases

    def add_author(self, author: Author) -> Author:
        """Add new author to the library."""
        logger.debug(f"Add author <{author}> to the library.")

        if self._check:
            author = self.check_author(author)
        if author.key not in self.authors:
            self._authors[author.key] = author
        else:
            logger.debug(f"Author <{author}> is already in the library!")
        return author

    def add_authors(self, *authors: Author) -> None:
        """Add multiple new authors."""
        for author in authors:
            self.add_author(author)

    def add_publication(self, publication: Publication) -> None:
        """Add new publication to the library."""
        logger.debug(f"Add publication <{publication}> to the library.")

        # check if publication already exist before adding to library
        if publication.key in self.publications:
            logger.info(f"Publication <{publication}> is already in the library!")
            logger.info("Hence the publication was not added!")
            return None

        # get aliases of authors
        aliases = self.get_aliases(inverse=True)

        # check if authors already exist
        for key, author in list(publication.authors.items()):
            # author was not observed so far
            if key not in self.authors and author.name not in aliases:
                key = self.add_author(author).key

            # author was previously observed under an other name
            elif key not in self.authors and author.name in aliases:
                alias = aliases[author.name]
                for uid in list(publication.authors.keys()):
                    if uid == key:
                        publication.authors[alias] = publication.authors.pop(uid)
                    else:
                        publication.authors[uid] = publication.authors.pop(uid)

                key = alias

            publication.authors[key] = self.authors[key]

        # add new publication to the library
        self._publications[publication.key] = publication

        # update authors publications
        for key in publication.authors.keys():
            self.authors[key].add_publication(publication)

    def add_publications(self, *publications: Publication) -> None:
        """Add multiple new publications."""
        for publication in publications:
            self.add_publication(publication)

    # def check_author(self, author: Author, threshold: float = 0.8) -> Author:
    #     """Check if authors exists already."""
    #     raise NotImplementedError
    #     # check if last name exist already
    #     if author.last in self._names:

    #         # check if mapping exist
    #         if author.name in self._name_map:
    #             return self.authors[self._name_map[author.name]]

    #         # get potential other options
    #         others = [self.authors[n] for n in self._names[author.last]]

    #         for new, old in itertools.product([author], others):
    #             # check orcid
    #             if new.orcid and old.orcid and new.orcid == old.orcid:
    #                 raise NotImplementedError

    #             print("=" * 79)
    #             print(f"New author <{new}>")
    #             print("\n      vs\n")
    #             print(f"Existing author <{old}>\n")
    #             print("0 - Ignore existing author")
    #             print("1 - Overwrite existing author")
    #             print("2 - Use existing author\n")
    #             var = input("Please select an option (default: 0) ")
    #             var = int(var) if var else 0
    #             print(f"You entered: {var}")
    #             print("=" * 79)
    #             if var == 2:
    #                 return old
    #             elif var == 1:
    #                 return self._update_author(old, new)

    #     return author

    def _update_author(self, old: Author, new: Author) -> Author:
        """Update author."""
        logger.debug(f"Update <{old}> from <{new}>.")
        # store old key
        key_old = old.key
        # update author class
        old.update(new)

        # get new key
        key_new = old.key

        # finish update if key has not changed
        if key_old == key_new:
            return old

        # Update key values
        self.authors[key_new] = self.authors.pop(key_old)

        # Reindex publications
        self.reindex_publications()

        return old

    def reindex_publications(self) -> None:
        """Reindex publications."""
        for key, publication in list(self.publications.items()):
            self.publications[publication.key] = self.publications.pop(key)
            for ref, refernce in list(publication.references.items()):
                publication.references[refernce.key] = publication.references.pop(ref)

        for author in list(self.authors.values()):
            for key, publication in list(author.publications.items()):
                author.publications[publication.key] = author.publications.pop(key)

    def _check_first(self, name_1: str, name_2: str, threshold: float = 0.8) -> bool:
        """Check similarity between two names."""
        lst_1 = name_1.split(" ")
        lst_2 = name_2.split(" ")
        compare: bool = False

        # check similarity of first first name
        if similarity(lst_1[0], lst_2[0]) >= threshold:
            compare = True
        # check similarity of name string
        elif similarity(name_1, name_2) >= threshold:
            compare = True
        # check if only short form is given
        elif "." in name_1 or "." in name_2:
            str_1 = " ".join([n[0] for n in lst_1])
            str_2 = " ".join([n[0] for n in lst_2])
            if similarity(str_1, str_2) >= threshold:
                compare = True
            elif similarity(lst_1[0][0], lst_2[0][0]) >= threshold:
                compare = True

        return compare

    def _check_authors_to_csv(self, data: Set, **kwargs: Any) -> None:
        """Save authors to check to csv file."""
        table = []
        columns = kwargs.get("columns", [])
        row = ["Key", "Author"]
        if "orcid" in columns:
            row.append("orcid")
        table.append(row)

        for author in data:
            row = [author.key, author.name]
            if "orcid" in columns:
                row.append(author.orcid)

            table.append(row)

        filename = kwargs.get("filename", "check.csv")
        # Write the data to a CSV file
        with open(filename, "w", newline="") as f:
            writer = csv.writer(f)
            writer.writerows(table)

    def _check_authors_from_csv(self, **kwargs) -> List:
        """Load csv with merge requests."""
        tasks = []
        filename = kwargs.get("filename")
        with open(filename, "r", newline="") as f:
            for row in csv.DictReader(f):
                if int(row["Action"]) != 0:
                    tasks.append(
                        (
                            self.authors[row["Key 1"]],
                            self.authors[row["Key 2"]],
                            int(row["Action"]),
                        )
                    )

        return tasks

    def merge_authors(self, *tasks: Tuple, **kwargs: Any) -> None:
        """Combine different authors."""
        if kwargs.get("filename"):
            tasks = self._check_authors_from_csv(**kwargs)

        if tasks and len(tasks[0]) == 3:
            for a1, a2, action in tasks:
                old = a2.key if action == 1 else a1.key
                new = a1.key if action == 1 else a2.key

                self._update_author(self.authors[old], self.authors[new])

        elif tasks and len(tasks[0]) == 2:
            for a1, a2 in tasks:
                self._update_author(self.authors[a1.key], self.authors[a2.key])

    def check_authors(
        self, threshold: float = 0.8, size: int = 3, **kwargs: Any
    ) -> Set:
        """Check if authors are okay."""
        last = defaultdict(set)
        for key, author in self.authors.items():
            last[author.last].add(key)

        # check for duplicated last names
        duplicates = {}
        for key, values in last.items():
            if len(values) > 1:
                duplicates[key] = values

        check = set()
        # collect authors with same last name
        for duplicate in duplicates.values():
            for key_1, key_2 in itertools.combinations(duplicate, 2):
                if self._check_first(
                    self.authors[key_1].first,
                    self.authors[key_2].first,
                    threshold=threshold,
                ):
                    check.add(self.authors[key_1])
                    check.add(self.authors[key_2])

        for key_1, key_2 in window(list(self.authors.keys()), size=size):
            str_1 = self.authors[key_1].last
            str_2 = self.authors[key_2].last
            if str_1 != str_2 and similarity(str_1, str_2) >= threshold:
                if self._check_first(
                    self.authors[key_1].first,
                    self.authors[key_2].first,
                    threshold=threshold,
                ):
                    check.add(self.authors[key_1])
                    check.add(self.authors[key_2])

        if kwargs.get("filename") or kwargs.get("to_csv", False):
            self._check_authors_to_csv(check, **kwargs)

        return check

    def get_statistics_by_year(self):
        """
        Get statistics for publications and authors by year.

        Returns:
            dict: A dictionary where keys are years, and values are dictionaries with:
                - 'num_papers': Number of papers
                - 'num_authors': Number of unique authors
        """
        stats_by_year = {}

        for pub in self.publications.values():
            year = pub.year
            if year not in stats_by_year:
                stats_by_year[year] = {"num_papers": 0, "authors": set()}

            stats_by_year[year]["num_papers"] += 1
            stats_by_year[year]["authors"].update(pub.authors.keys())

        # Convert sets of authors to counts
        for year, stats in stats_by_year.items():
            stats["num_authors"] = len(stats["authors"])
            del stats["authors"]  # Remove the set to keep data clean

        return stats_by_year

    def add_from_bib_file(self, bib_file: str) -> None:
        """Add publications from bib file."""
        # TODO add file testing.

        # extract entries from bibtex file
        library = bp.parse_file(bib_file)

        # convert entries to publications
        for entry in library.entries:
            self.add_publication(Publication.from_bib(entry.raw))

    def to_json(self, **kwargs: Any) -> str:
        """Convert Library to json string."""
        logger.debug("Convert Library to json.")
        authors = {key: value.to_dict() for key, value in self.authors.items()}
        publications = {}
        for key, value in self.publications.items():
            publications[key] = value.to_dict()
        data = {
            "filename": kwargs.get("filename", self._filename),
            "publications": publications,
            "authors": authors,
        }
        return json.dumps(data, ensure_ascii=False, indent=4)

    def link_data(self) -> None:
        """Link external data with library."""
        for publication in self.publications.values():
            publication.link_data()

    @classmethod
    def from_json(cls, json_string: str) -> Self:
        """Create Library from json entry."""
        data = json.loads(json_string)
        lib = cls(filename=data.get("filename", ""))

        # Add authors
        for value in data["authors"].values():
            lib.add_author(Author.from_dict(value))

        # Add publications
        for value in data["publications"].values():
            lib.add_publication(Publication.from_dict(value))

        return lib

    def save(self, filename: str = "") -> None:
        """Save Library to file."""
        filename = filename if filename else self._filename
        with open(filename, "w", encoding="utf-8") as f:
            f.write(self.to_json(filename=filename))

    @classmethod
    def load(cls, filename: str = "", link_data: bool = False) -> Self:
        """Load Library from file."""
        filename = filename if filename else config["library"]["filename"]
        with open(filename, "r", encoding="utf8") as f:
            data = f.read()
        new = cls.from_json(data)

        # link referenced publications
        for publication in new.publications.values():
            if publication.references:
                for key, reference in publication.references.items():
                    if key in new.publications and reference is None:
                        publication.references[key] = new.publications[key]

        if link_data:
            new.link_data()
        return new
