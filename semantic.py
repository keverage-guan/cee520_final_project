import os
import json
from typing import List, Dict, Any
from collections import defaultdict, Counter

import spacy
from sklearn.feature_extraction.text import TfidfVectorizer
from tqdm import tqdm

import importlib
import scinetextractor
importlib.reload(scinetextractor)
from scinetextractor import Library

# === Configuration Parameters ===
DATA_DIR = "mto/data"  # Directory containing article JSON files
CACHE_PATH = "mto_keywords_cache.json"  # Intermediate cache for extracted keywords
LIBRARY_PATH = "mto/mto_library.json"  # Path to base library file
KEYWORDS_PATH = "mto_keywords.json"  # Final keyword output
MODEL_NAME = "paraphrase-MiniLM-L12-v2"  # Placeholder for embedding model (not used here)
TOP_N = 10  # Number of top keywords to extract


def load_article_texts(data_dir: str) -> List[Dict[str, Any]]:
    """
    Load all article files and construct a unified text field from title, abstract, and body.

    Args:
        data_dir: Path to folder of .json article files.

    Returns:
        List of dicts, each with keys:
            - filename: original file name
            - text: full string for TF-IDF
            - title: article title
            - authors: author list
            - year: publication year (int or None)
    """
    articles = []
    files = [f for f in os.listdir(data_dir) if f.endswith(".json")]

    for fname in tqdm(files, desc="Loading articles"):
        with open(os.path.join(data_dir, fname), encoding="utf-8") as f:
            data = json.load(f)

        # Extract body text, which may be nested in paragraph structures
        paragraphs = data.get("paragraphs", [])
        if isinstance(paragraphs, list):
            body_text = " ".join(
                v.get("text", "") for para in paragraphs for v in para.values() if isinstance(v, dict)
            )
        else:
            # Fallbacks if "paragraphs" key is missing or malformed
            body_text = data.get("body", data.get("content", ""))

        # Combine fields into one searchable document string
        full_text = " ".join([
            data.get("title", ""),
            data.get("abstract", ""),
            body_text
        ])

        # Extract year from ISO-style date string
        articles.append({
            "filename": fname,
            "text": full_text,
            "title": data.get("title", ""),
            "authors": data.get("authors", []),
            "year": int(data["date"][:4]) if data.get("date", "").strip() else None
        })

    return articles


def extract_keywords_tfidf(
    articles: List[Dict[str, Any]],
    top_n: int = 10,
    output_path: str = KEYWORDS_PATH,
    cache_path: str = CACHE_PATH
) -> None:
    """
    Use TF-IDF to extract top-N keywords from articles, filtered by noun phrases.

    - Caches results for incremental reruns.
    - Uses spaCy to restrict to grammatical noun phrases.

    Args:
        articles: List of article dicts from `load_article_texts`.
        top_n: Number of keywords to retain per article.
        output_path: File to write final keywords (JSON).
        cache_path: Path for caching in-progress results.
    """
    nlp = spacy.load("en_core_web_md", disable=["ner"])  # Use medium-sized spaCy model for efficiency

    # Load prior cache to avoid recomputation
    if os.path.exists(cache_path):
        with open(cache_path, "r", encoding="utf-8") as f:
            raw_cache = json.load(f)
        cache = raw_cache if isinstance(raw_cache, dict) else {entry["filename"]: entry for entry in raw_cache}
    else:
        cache = {}

    # Skip articles that are already in the cache
    new_articles = [a for a in articles if a["filename"] not in cache]
    if not new_articles:
        print("All articles already processed (loaded from cache).")
        with open(output_path, "w", encoding="utf-8") as f:
            json.dump(list(cache.values()), f, indent=2)
        return

    # Vectorize entire corpus with TF-IDF, keeping up to 10,000 terms, 1- to 3-grams
    texts = [a["text"] for a in articles]
    vectorizer = TfidfVectorizer(stop_words="english", ngram_range=(1, 3), max_features=10000)
    tfidf_matrix = vectorizer.fit_transform(texts)
    feature_names = vectorizer.get_feature_names_out()

    for i, article in enumerate(tqdm(articles, desc="Extracting TF-IDF keywords")):
        if article["filename"] in cache:
            continue

        # Retrieve top-N*3 terms (some will be filtered out later)
        row = tfidf_matrix[i].toarray().flatten()
        top_indices = row.argsort()[-top_n * 3:][::-1]
        candidate_terms = [feature_names[idx] for idx in top_indices]

        # Filter TF-IDF keywords to only keep noun phrases from spaCy
        doc = nlp(article["text"])
        noun_phrases = set(chunk.text.lower() for chunk in doc.noun_chunks)
        filtered = [kw.rstrip(".") for kw in candidate_terms if kw.lower() in noun_phrases and len(kw.strip()) > 1][:top_n]

        # Store result
        record = {
            "filename": article["filename"],
            "title": article["title"],
            "authors": article["authors"],
            "year": article["year"],
            "keywords": filtered
        }

        cache[article["filename"]] = record

        # Periodically save to disk for safety
        if len(cache) % 10 == 0:
            with open(cache_path, "w", encoding="utf-8") as f:
                json.dump(list(cache.values()), f, indent=2)

    # Final save to both cache and output file
    with open(cache_path, "w", encoding="utf-8") as f:
        json.dump(list(cache.values()), f, indent=2)
    with open(output_path, "w", encoding="utf-8") as f:
        json.dump(list(cache.values()), f, indent=2)

    print(f"Cached keywords for {len(cache)} articles → {output_path}")


def count_global_keywords(
    keywords_path: str = "mto_keywords.json",
    output_path: str = "keyword_global_counts.json",
    print_top_n: int = 20,
    save_txt: bool = False,
    txt_path: str = "top_keywords.txt"
) -> None:
    """
    Aggregate and count keyword frequencies across all articles.

    Args:
        keywords_path: Path to keyword extraction JSON.
        output_path: Path to write frequency count JSON.
        print_top_n: Number of top keywords to show in terminal.
        save_txt: Whether to also export top keywords to .txt file.
        txt_path: Location for text file (if enabled).
    """
    with open(keywords_path, "r", encoding="utf-8") as f:
        articles = json.load(f)

    keyword_counter = Counter()
    total_docs = 0

    for article in articles:
        # Convert to set to avoid duplicate keywords within one article
        kws = set(article.get("keywords", []))
        total_docs += 1
        keyword_counter.update(kws)

    # Save JSON-formatted global counts
    with open(output_path, "w", encoding="utf-8") as f:
        json.dump(keyword_counter.most_common(), f, indent=2)

    top_keywords = keyword_counter.most_common(print_top_n)

    print(f"Top {print_top_n} keywords across {total_docs} articles:")
    for kw, count in top_keywords:
        print(f"{kw:40} {count}")
    print(f"Total unique keywords: {len(keyword_counter)}")

    if save_txt:
        with open(txt_path, "w", encoding="utf-8") as f:
            for kw, _ in top_keywords:
                f.write(f"{kw}\n")
        print(f"Top {print_top_n} keywords written to {txt_path}")


def enrich_library_with_keywords_from_file(
    library_path: str,
    keywords_path: str,
    output_path: str,
    stopword_file: str = "stopwords.txt"
) -> None:
    """
    Enrich a Library object with keyword metadata at both publication and author level.

    Args:
        library_path: Path to base MTO library.
        keywords_path: Keyword data to be integrated.
        output_path: Where to save the enriched library.
        stopword_file: List of stopwords to exclude from authors' vocabularies.
    """
    # Load stopwords from text file
    with open(stopword_file, "r", encoding="utf-8") as f:
        stopwords = set(line.strip().lower() for line in f if line.strip())

    # Load the base library and keyword annotations
    lib = Library.load(library_path, link_data=True)
    with open(keywords_path, "r", encoding="utf-8") as f:
        keyword_records = json.load(f)

    # Create title → keyword list mapping, filtering out stopwords
    paper_keywords = {
        record["title"]: [
            kw for kw in record.get("keywords", [])
            if kw and kw.strip().lower() not in stopwords
        ]
        for record in keyword_records
    }

    unmatched = []
    for pub in lib.publications.values():
        pub_id = pub.data.get("title")
        if pub_id in paper_keywords:
            pub.set_keywords(paper_keywords[pub_id])
        else:
            pub.data["keywords"] = []
            unmatched.append(pub_id)

    if unmatched:
        print(f"{len(unmatched)} publications had no matching keyword record.")
        print("  Sample:", unmatched[:5])

    # Aggregate author-level keywords per year
    author_keywords_by_year = defaultdict(lambda: defaultdict(set))
    for pub in lib.publications.values():
        if pub.year is None:
            continue
        for author_id in pub.authors:
            author_keywords_by_year[author_id][pub.year].update(pub.keywords)

    # Set author data → {year: [keywords]}
    for author_id, year_map in author_keywords_by_year.items():
        author = lib.authors[author_id]
        author.data["keywords"] = {
            year: sorted(kws) for year, kws in year_map.items()
        }

    lib.save(output_path)
    print(f"Enriched library saved to: {output_path}")


def main() -> None:
    """
    Entry point to run enrichment. Uncomment other steps as needed.
    """
    # Uncomment below to run full pipeline from scratch:
    # articles = load_article_texts(DATA_DIR)
    # extract_keywords_tfidf(articles, top_n=10)
    # count_global_keywords(print_top_n=100, save_txt=True)

    print("Enriching library with keywords...")
    enrich_library_with_keywords_from_file(
        library_path=LIBRARY_PATH,
        keywords_path=KEYWORDS_PATH,
        output_path="mto/mto_library_with_keywords.json",
        stopword_file="stopwords.txt"
    )


if __name__ == "__main__":
    main()
