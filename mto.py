"""
mto.py

Main file to run mto analysis
"""

import subprocess
from pathlib import Path
import json
import os
import networkx as nx
import bibtexparser as bp
from scinetextractor import Library
from scinetextractor import Author
from scinetextractor import Publication
from mto_scraper import MTOScraper
from mto_client import MTOClient
from collections import defaultdict, Counter
from itertools import combinations, product
from collections import deque
import importlib
# reimport scinetextractor
import scinetextractor
importlib.reload(scinetextractor)
from typing import Optional

# variables
PATH = "./mto"
FILENAME = PATH + "/mto_library.json"
DOWNLOADS = "mto/raw"
DATA = "mto/data"


def setup(filename: str = FILENAME) -> None:
    """Create folder for documents."""
    # Define the directory path
    directory_path = Path(PATH)

    # Create the directory if it doesn't exist
    directory_path.mkdir(parents=True, exist_ok=True)

    # Check if library exist and if not create it
    if not Path(FILENAME).exists():
        lib = Library(filename=filename)

        # save library to json
        lib.save()


def cleanup(filename: str = FILENAME) -> None:
    """Clean folder structure for debugging."""
    # Define the library path
    file_path = Path(filename)
    try:
        file_path.unlink()
        print(f"File '{file_path}' deleted successfully.")
    except FileNotFoundError:
        print(f"Error: File '{file_path}' not found.")


def scrape_publications(issues: str = "issues.json", download: bool = False) -> None:
    """Scrape publications from the web"""
    issues_page_url = "https://www.mtosmt.org/issues/issues.php"
    prefix = "https://mtosmt.org/issues/"

    scraper = MTOScraper(issues_page_url, prefix, download_folder=DOWNLOADS)

    print("Starting scraping process...")
    scraper.scrape(filename=issues)

    # optional: Download all article pages.
    # DON'T DO IT IF NOT NEEDED
    if download:
        print("Starting download process...")
        scraper.download_all_articles()


def process_publications(issues: str = "issues.json") -> None:
    """Process raw article to json."""
    with open(issues, "r", encoding="utf-8") as f:
        issues = json.load(f)

    client = MTOClient()
    folder = DOWNLOADS
    fixed_keys = {"url", "volume", "number", "date"}
    for issue in issues:
        for key, links in issue.items():
            if key in fixed_keys:
                continue
            for link in links:
                filename = os.path.basename(link.split("?")[0])
                path = os.path.join(folder, filename)
                client.to_json(path, DATA, mto=True, category=key)


def create_library(filename: str = FILENAME, path: str = DATA) -> None:
    """Create a library from from json data."""
    # Cleanup library
    cleanup(filename=filename)

    # Setup library structure
    setup(filename=filename)

    lib = Library.load(filename)

    for filename in [os.path.join(path, f) for f in os.listdir(path)]:
        if not filename.endswith(".json"):
            continue

        with open(filename, "r", encoding="utf-8") as f:
            data = json.load(f)

        info = data["author_info"]
        for i, author in enumerate(data["authors"]):
            if info:
                features = {
                    "university": info[i]["university"],
                    "address": info[i]["address"],
                    "email": info[i]["email"],
                    "mto": True,
                }
            else:
                features = {"university": "", "address": "", "email": "", "mto": True}
            lib.add_author(Author(author, data=features))

        try:
            year = int(data["date"][:4])
        except ValueError:
            continue
        doi = data["doi"] if data["doi"] else None
        lib.add_publication(
            Publication(
                year=year,
                title=data["title"],
                authors=data["authors"],
                doi=doi,
                data={
                    "mto": data.get("mto", False),
                    "category": data.get("category"),
                },
                source=data.get("data"),
            )
        )

    lib.save()
    print(lib)


def create_references(filename: str = FILENAME, external: bool = True) -> None:
    """Create and link references of each paper."""
    lib = Library.load(filename, link_data=True)
    key_map = {p.make_key(use_doi=False): k for k, p in lib.publications.items()}
    vol_map = defaultdict(lambda: defaultdict(dict))
    for k, publication in lib.publications.items():
        vol = int(publication.data["volume"])
        iss = int(publication.data["issue"])
        name = list(publication.authors.values())[0].last
        vol_map[vol][iss][name] = k

    total = len(lib.publications.values())
    for k, publication in enumerate(list(lib.publications.values())):
        print(f"[{k}/{total}] Working on: {publication}")
        with open("test.txt", "w") as f:
            for line in publication.data["citations"].values():

                f.write(line.replace('\n', ' ') + "\n")

        output = subprocess.run(
            ["anystyle", "-f", "bib", "parse", "test.txt"],
            capture_output=True,
            text=True,
            # shell=True
        ).stdout

        # Change bib key to html key
        library = bp.parse_string(output)
        bib_file = ""

        for i, entry in enumerate(library.entries):
            original_key = list(publication.data["citations"].keys())[i]
            bib_file += str(entry.raw).replace(entry.key, original_key) + "\n"

        # Reload library
        library = bp.parse_string(bib_file)
        for i, entry in enumerate(library.entries):
            doi = entry.get("doi").value if entry.get("doi") else None
            journal = entry.get("journal").value if entry.get("journal") else None

            if doi and "mto" in doi and journal and "Music Theory Online" in journal:
                mto = True
            elif journal and "Music Theory Online" in journal:
                mto = True
            elif doi and "mto" in doi:
                mto = True
            else:
                mto = False

            if not mto and external:
                new = Publication.from_bib(
                    entry.raw, data={"mto": False, "category": "external"}
                )
                lib.add_publication(new)
                publication.references[new.key] = lib.publications[new.key]
            elif mto:
                new = Publication.from_bib(entry.raw)
                if new.key in lib.publications:
                    _key = new.key
                elif new.make_key(use_doi=False) in lib.publications:
                    _key = new.make_key(use_doi=False)
                elif new.make_key(use_doi=False) in key_map:
                    _key = key_map[new.make_key(use_doi=False)]
                elif (
                    entry.get("volume") and entry.get("number") and entry.get("author")
                ):
                    try:
                        vol = int(entry.get("volume").value)
                        iss = int(entry.get("number").value)
                        name = entry.get("author").value.split(",")[0].strip()
                        _key = (
                            vol_map[vol][iss][name]
                            if name in vol_map[vol][iss]
                            else None
                        )
                    except ValueError:
                        _key = None
                else:
                    _key = None

                if _key:
                    publication.references[_key] = lib.publications[_key]

                    if doi and lib.publications[_key].doi is None:
                        lib.publications[_key]._doi = doi
                else:
                    print(f"--> Not Found: <{entry.get('title').value}>")
                    pass

    lib.reindex_publications()
    lib.save()
    print(lib)

def generate_citation_network(library: Library, output_path: str = "mto_citations.gexf") -> None:
    """
    Generate a graph of publications with two types of edges:
    - Direct citation: A → B if A cites B
    - Shared reference: A ↔ B if A and B cite the same third publication

    Node attributes:
        - title, year, authors, category, keywords

    Edge attributes:
        - type: 'direct_citation' or 'shared_reference'
        - year: year of citing publication
        - years_since_1993: year - 1993

    Args:
        library: Loaded Library object containing publications
        output_path: File path to write the GEXF graph
    """
    G = nx.Graph()

    def safe_str(x): return str(x) if x is not None else ""
    def safe_int(x): return int(x) if isinstance(x, int) else -1

    # Add publication nodes
    for pub_id, pub in library.publications.items():
        G.add_node(
            pub_id,
            title=safe_str(pub._title),
            year=safe_int(pub.year),
            authors=safe_str(", ".join(author.name for author in pub.authors.values())),
            category=safe_str(pub.data.get("category")),
            keywords="; ".join(pub.keywords)
        )

    # Add direct citation edges
    for pub_id, pub in library.publications.items():
        citing_year = safe_int(pub.year)
        years_since_1993 = citing_year - 1993 if citing_year >= 0 else -1

        for cited_id in pub.references:
            if cited_id in library.publications:
                G.add_edge(
                    pub_id, cited_id,
                    type="direct_citation",
                    year=citing_year,
                    years_since_1993=years_since_1993
                )

    # Build reverse citation index for shared-reference edges
    reverse_citations = defaultdict(set)
    for pub_id, pub in library.publications.items():
        for cited in pub.references:
            if cited in library.publications:
                reverse_citations[cited].add(pub_id)

    # Add shared-reference edges for each pair that cites the same paper
    for citing_pubs in reverse_citations.values():
        citing_list = list(citing_pubs)
        for i in range(len(citing_list)):
            for j in range(i + 1, len(citing_list)):
                a, b = citing_list[i], citing_list[j]
                if G.has_edge(a, b):
                    continue  # Don't overwrite direct citations
                year_a = safe_int(library.publications[a].year)
                years_since = year_a - 1993 if year_a >= 0 else -1
                G.add_edge(
                    a, b,
                    type="shared_reference",
                    year=year_a,
                    years_since_1993=years_since
                )

    nx.write_gexf(G, output_path)
    print(f"Citation graph (with shared references) saved to: {output_path}")


def generate_author_network(library: Library) -> None:
    """
    Generate an undirected graph of authors where an edge indicates co-authorship.

    Args:
        library: Loaded Library object
    """
    G = nx.Graph()

    for u, author in library.authors.items():
        G.add_node(u)
        for v in author.collaborators:
            G.add_edge(u, v)

    nx.write_gexf(G, "mto_collaborations.gexf")
    print(f"Author collaboration network saved to: mto_collaborations.gexf")


def generate_author_relationships(
    library: Library,
    output_path: str = "mto_author_relationships.json"
) -> None:
    """
    Generate author-level relationships:
    - Collaborations (unordered pairs of authors who co-wrote a paper)
    - Citations (directed pairs from citing author to cited author)

    Args:
        library: Loaded Library object
        output_path: JSON file path to write relationships
    """
    collaborations = Counter()
    citations = Counter()

    for pub in library.publications.values():
        author_ids = list(pub.authors)

        # Count collaborations (unordered)
        for a1, a2 in combinations(author_ids, 2):
            pair = tuple(sorted((a1, a2)))
            collaborations[pair] += 1

        # Count citations (ordered)
        for cited_pub in pub.references.values():
            citing_authors = author_ids
            cited_authors = list(cited_pub.authors)
            for a1, a2 in product(citing_authors, cited_authors):
                citations[(a1, a2)] += 1

    with open(output_path, "w", encoding="utf-8") as f:
        json.dump({
            "collaborations": {f"{a1};{a2}": count for (a1, a2), count in collaborations.items()},
            "citations": {f"{a1}:{a2}": count for (a1, a2), count in citations.items()}
        }, f, indent=2)

    print(f"Author relationships saved to: {output_path}")


def generate_author_interaction_graph(
    library: Library,
    output_path: str = "mto_author_interactions.gexf"
) -> None:
    """
    Generate a directed multigraph of authors with two types of edges:
    - 'collaboration': authors co-authored a paper
    - 'citation': one author cited another's work

    Node attributes include name, affiliation, location, and keywords.

    Args:
        library: Loaded Library object
        output_path: File path to write the GEXF graph
    """
    G = nx.MultiDiGraph()

    def safe_str(x): return str(x) if x is not None else ""
    def safe_int(x): return int(x) if isinstance(x, int) else -1

    # Compute first publication year per author
    first_year = {}
    for pub in library.publications.values():
        for author_id in pub.authors:
            year = pub.year
            if author_id not in first_year or (year is not None and year < first_year[author_id]):
                first_year[author_id] = year

    # Add author nodes with metadata
    for author_id, author in library.authors.items():
        data = author.data or {}
        G.add_node(
            author_id,
            label=safe_str(author.name),
            first_year=safe_int(first_year.get(author_id)),
            university=safe_str(data.get("university", "")),
            city=safe_str(data.get("geo_city", "")),
            state=safe_str(data.get("geo_state", "")),
            country=safe_str(data.get("geo_country", "")),
            latitude=safe_str(data.get("lat", "")),
            longitude=safe_str(data.get("lng", "")),
            keywords=author.data.get("keywords", [])
        )

    # Add collaboration and citation edges
    for pub in library.publications.values():
        year = safe_int(pub.year)
        years_since_1993 = year - 1993 if year >= 0 else -1
        authors = list(pub.authors)

        # Symmetric collaboration edges (both directions)
        for a1, a2 in combinations(authors, 2):
            G.add_edge(a1, a2, relation="collaboration", year=year, years_since_1993=years_since_1993)
            G.add_edge(a2, a1, relation="collaboration", year=year, years_since_1993=years_since_1993)

        # Asymmetric citation edges
        for cited_pub in pub.references.values():
            for a1 in authors:
                for a2 in cited_pub.authors:
                    G.add_edge(a1, a2, relation="citation", year=year, years_since_1993=years_since_1993)

    nx.write_gexf(G, output_path)
    print(f"Author interaction graph saved to: {output_path}")

from collections import deque


def generate_keyword_linked_article_graph(
    library: Library,
    output_path: str = "mto_article_keyword_links.gexf",
    keyword_count_file: str = "keyword_global_counts.json",
    min_keyword_count: int = 1
) -> None:
    """
    Create an undirected graph where articles are nodes, and edges link articles
    that share one or more keywords above a minimum frequency.

    Node attributes:
        - title, year, authors, category, keywords

    Edge attributes:
        - keywords: shared keyword list
        - weight: number of shared keywords

    Args:
        library: Loaded Library object
        output_path: Path to save the GEXF file
        keyword_count_file: Path to keyword_global_counts.json
        min_keyword_count: Minimum number of times a keyword must appear globally
    """
    G = nx.Graph()

    def safe_str(x): return str(x) if x is not None else ""
    def safe_int(x): return int(x) if isinstance(x, int) else -1

    # Load global keyword frequencies and filter to valid keywords
    with open(keyword_count_file, "r", encoding="utf-8") as f:
        global_counts = json.load(f)
        valid_keywords = {kw for kw, count in global_counts if count >= min_keyword_count}

    # Add article nodes with metadata
    for pub_id, pub in library.publications.items():
        G.add_node(
            pub_id,
            title=safe_str(pub._title),
            year=safe_int(pub.year),
            authors=safe_str(", ".join(author.name for author in pub.authors.values())),
            category=safe_str(pub.data.get("category")),
            keywords="; ".join(pub.keywords)
        )

    # Build inverse index: keyword → set of article IDs
    keyword_to_papers = defaultdict(set)
    for pub_id, pub in library.publications.items():
        for kw in pub.data.get("keywords", []):
            if kw in valid_keywords:
                keyword_to_papers[kw].add(pub_id)

    # Track article pairs and their shared keywords
    pair_keywords = defaultdict(set)
    for kw, papers in keyword_to_papers.items():
        for id1, id2 in combinations(sorted(papers), 2):
            pair = tuple(sorted((id1, id2)))
            pair_keywords[pair].add(kw)

    # Add edges for each article pair
    for (id1, id2), keywords in pair_keywords.items():
        G.add_edge(
            id1, id2,
            keywords="; ".join(sorted(keywords)),
            weight=len(keywords)
        )

    nx.write_gexf(G, output_path)
    print(f"Keyword-linked article graph saved to {output_path} with {len(G.edges())} edges.")


def generate_semantic_reachability_graph(
    library: Library,
    max_depth: int = 2,
    output_path: str = "mto_semantic_reachability.gexf"
) -> None:
    """
    Create a directed graph where edge A → B exists if:
    - B is reachable from A within ≤ max_depth steps in the citation graph
    - A and B share one or more keywords

    Edge attributes:
        - keywords: shared keywords
        - weight: number of shared keywords
        - depth: citation path depth from A to B

    Args:
        library: Loaded Library object
        max_depth: Maximum citation distance to consider
        output_path: File path for the saved GEXF graph
    """
    G = nx.DiGraph()

    def safe_str(x): return str(x) if x is not None else ""
    def safe_int(x): return int(x) if isinstance(x, int) else -1

    # Add publication nodes
    for pub_id, pub in library.publications.items():
        G.add_node(
            pub_id,
            title=safe_str(pub._title),
            year=safe_int(pub.year),
            authors=safe_str(", ".join(author.name for author in pub.authors.values())),
            category=safe_str(pub.data.get("category")),
            keywords="; ".join(pub.data.get("keywords", []))
        )

    # Build citation graph (directed)
    citation_graph = nx.DiGraph()
    for pub_id, pub in library.publications.items():
        for ref in pub.references:
            if ref in library.publications:
                citation_graph.add_edge(pub_id, ref)

    edge_counts_by_depth = defaultdict(int)

    # For each source publication, explore reachable publications within max_depth
    for start in citation_graph.nodes():
        if start not in library.publications:
            continue

        start_keywords = set(library.publications[start].data.get("keywords", []))
        if not start_keywords:
            continue

        visited = set()
        queue = deque([(start, 0)])

        while queue:
            current, depth = queue.popleft()
            if depth > max_depth or (current, depth) in visited:
                continue
            visited.add((current, depth))

            if current != start and current in library.publications:
                target_keywords = set(library.publications[current].data.get("keywords", []))
                shared = start_keywords & target_keywords
                if shared:
                    G.add_edge(
                        start,
                        current,
                        keywords="; ".join(sorted(shared)),
                        weight=len(shared),
                        depth=depth
                    )
                    edge_counts_by_depth[depth] += 1

            for neighbor in citation_graph.successors(current):
                queue.append((neighbor, depth + 1))

    nx.write_gexf(G, output_path)
    print(f"Saved semantic reachability graph to {output_path} (max_depth = {max_depth})")
    total = sum(edge_counts_by_depth.values())
    print(f"🔗 Total edges added: {total}")
    for d in sorted(edge_counts_by_depth):
        print(f"   Depth {d}: {edge_counts_by_depth[d]} edges")


def generate_temporal_keyword_graph(
    library: Library,
    year_range: int = 1,
    output_path: str = "mto_temporal_keyword_graph.gexf"
) -> None:
    """
    Generate an undirected graph where two papers are connected if:
    - They share at least one keyword
    - Their publication years differ by at most year_range

    Edge attributes:
        - keywords: shared terms
        - weight: number of shared terms
        - year_diff: absolute difference in publication year

    Args:
        library: Loaded Library object
        year_range: Maximum year difference allowed
        output_path: GEXF output path
    """
    G = nx.Graph()

    def safe_str(x): return str(x) if x is not None else ""
    def safe_int(x): return int(x) if isinstance(x, int) else -1

    # Add article nodes
    for pub_id, pub in library.publications.items():
        G.add_node(
            pub_id,
            title=safe_str(pub._title),
            year=safe_int(pub.year),
            authors=safe_str(", ".join(author.name for author in pub.authors.values())),
            category=safe_str(pub.data.get("category")),
            keywords="; ".join(pub.data.get("keywords", []))
        )

    # Compare article pairs
    pub_list = list(library.publications.items())
    for i in range(len(pub_list)):
        id_a, pub_a = pub_list[i]
        year_a = pub_a.year
        if year_a is None:
            continue
        keywords_a = set(pub_a.data.get("keywords", []))

        for j in range(i + 1, len(pub_list)):
            id_b, pub_b = pub_list[j]
            year_b = pub_b.year
            if year_b is None:
                continue
            if abs(year_a - year_b) > year_range:
                continue

            keywords_b = set(pub_b.data.get("keywords", []))
            shared = keywords_a & keywords_b
            if shared:
                G.add_edge(
                    id_a,
                    id_b,
                    keywords="; ".join(sorted(shared)),
                    weight=len(shared),
                    year_diff=abs(year_a - year_b)
                )

    nx.write_gexf(G, output_path)
    print(f"Temporal keyword graph saved to {output_path} (year_range = {year_range})")


def collapse_multiedges_by_relation_and_year(
    input_file: str,
    output_file: Optional[str] = None
) -> None:
    """
    Collapse multi-edges in a MultiDiGraph where each (u, v, relation, year) combination
    becomes a single edge with an added count attribute.

    Used for simplifying dense graphs like author interactions.

    Args:
        input_file: Path to GEXF file with MultiDiGraph
        output_file: Path to save collapsed graph (defaults to *_collapsed.gexf)
    """
    if output_file is None:
        output_file = input_file.replace(".gexf", "_collapsed.gexf")

    G = nx.read_gexf(input_file)
    if not isinstance(G, nx.MultiDiGraph):
        raise ValueError("Expected MultiDiGraph input.")

    H = nx.DiGraph()
    H.add_nodes_from(G.nodes(data=True))

    edge_map = defaultdict(list)
    for u, v, k, data in G.edges(data=True, keys=True):
        key = (u, v, data.get("relation"), data.get("year"))
        edge_map[key].append(data)

    # Collapse edges: one per unique (u, v, relation, year) combo
    for (u, v, relation, year), edges in edge_map.items():
        combined_data = {
            "relation": relation,
            "year": year,
            "years_since_1993": edges[0].get("years_since_1993", -1),
            "count": len(edges)
        }
        H.add_edge(u, v, **combined_data)

    nx.write_gexf(H, output_file)
    print(f"Collapsed graph written to {output_file}")


def main():
    """Use the MTOClient."""
    # # DO NOT RUN THIS!
    # if False:
    #     # Scrape MTO to get publications
    #     scrape_publications()

    #     # Convert raw html to json data
    #     process_publications()

    # DO NOT RUN THIS IF NOT NEEDED!
    # if False:
        # Create library from json data
        # create_library()

        # Create and link library entries
        # create_references(external=False)

    lib = Library.load(PATH + "/mto_library_with_keywords.json", link_data=True)

    generate_citation_network(lib)
    # generate_author_network(lib)
    generate_author_relationships(lib)
    generate_author_interaction_graph(lib)
    generate_keyword_linked_article_graph(lib, min_keyword_count=5)
    generate_semantic_reachability_graph(lib, max_depth=2)
    generate_temporal_keyword_graph(lib, year_range=1)
    collapse_multiedges_by_relation_and_year("mto_author_interactions.gexf")

if __name__ == "__main__":
    main()