"""Natural Language Processing functions."""

import nltk

# from geograpy import extraction

# # from geograpy import places
# import geograpy

import locationtagger


def download_nltk_libraries() -> None:
    """Download nltk libraries."""
    nltk.downloader.download("maxent_ne_chunker")
    nltk.downloader.download("words")
    nltk.downloader.download("treebank")
    nltk.downloader.download("maxent_treebank_pos_tagger")
    nltk.downloader.download("punkt")
    nltk.downloader.download("averaged_perceptron_tagger")


def extract_locations(text: str) -> dict:
    """Extract Locations from string."""
    entities = locationtagger.find_locations(text=text)
    return {"countries": entities.countries, "cities": entities.cities}
