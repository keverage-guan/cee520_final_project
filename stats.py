import os
import json
import networkx as nx
import matplotlib.pyplot as plt
import pandas as pd
from collections import defaultdict
from networkx import DiGraph, read_gexf


def remove_self_loops(G: nx.Graph) -> nx.Graph:
    """
    Return a copy of the graph with all self-loops removed.
    """
    G_clean = G.copy()
    self_loops = list(nx.selfloop_edges(G_clean))
    G_clean.remove_edges_from(self_loops)
    return G_clean


def remove_isolates(G: nx.Graph) -> nx.Graph:
    """
    Return a copy of the graph with all isolated nodes removed.
    """
    G_clean = G.copy()
    isolates = list(nx.isolates(G_clean))
    G_clean.remove_nodes_from(isolates)
    return G_clean


def get_largest_component(G: nx.Graph) -> nx.Graph:
    """
    Return the largest connected component of the graph.
    Uses weakly connected components for directed graphs.
    """
    if G.is_directed():
        components = list(nx.weakly_connected_components(G))
    else:
        components = list(nx.connected_components(G))

    if not components:
        return G.__class__()  # Return an empty graph of the same type

    largest = max(components, key=len)
    return G.subgraph(largest).copy()


def graph_stats(G: nx.Graph) -> dict:
    """
    Compute a set of structural graph statistics.
    Returns:
        Dictionary with basic graph statistics and degree distributions.
    """
    stats = {
        "num_nodes": G.number_of_nodes(),
        "num_edges": G.number_of_edges(),
        "average_degree": round(sum(dict(G.degree()).values()) / G.number_of_nodes(), 2) if G.number_of_nodes() > 0 else 0,
        "isolated_nodes": len(list(nx.isolates(G))),
        "self_loops": nx.number_of_selfloops(G),
    }

    # Degree distribution
    degree_counts = defaultdict(int)
    for _, deg in G.degree():
        if deg > 0:
            degree_counts[str(deg)] += 1
    stats["degree_distribution"] = dict(sorted(degree_counts.items(), key=lambda x: int(x[0])))

    # In-degree and out-degree (if directed)
    if G.is_directed():
        in_counts, out_counts = defaultdict(int), defaultdict(int)
        for node in G.nodes():
            in_counts[str(G.in_degree(node))] += 1
            out_counts[str(G.out_degree(node))] += 1
        stats["in_degree_distribution"] = dict(sorted(in_counts.items(), key=lambda x: int(x[0])))
        stats["out_degree_distribution"] = dict(sorted(out_counts.items(), key=lambda x: int(x[0])))

    # Diameter and path length (if connected)
    try:
        undirected = G.to_undirected()
        if nx.is_connected(undirected):
            stats["diameter"] = nx.diameter(undirected)
            stats["avg_shortest_path_length"] = round(nx.average_shortest_path_length(undirected), 2)
        else:
            stats["diameter"] = None
            stats["avg_shortest_path_length"] = None
    except:
        stats["diameter"] = None
        stats["avg_shortest_path_length"] = None

    # Clustering
    try:
        stats["avg_clustering_coefficient"] = round(nx.average_clustering(G.to_undirected()), 4)
    except:
        stats["avg_clustering_coefficient"] = None

    return stats


def analyze_graph_versions(G: nx.Graph, label: str = "graph", outdir: str = "graph_stats") -> None:
    """
    Analyze three cleaned versions of the graph:
    - Without self-loops
    - Without self-loops or isolates
    - Largest connected component of the above
    Saves results to a JSON file in the specified output directory.
    """
    os.makedirs(outdir, exist_ok=True)

    versions = {}
    G1 = remove_self_loops(G)
    versions["no_self_loops"] = graph_stats(G1)

    G2 = remove_isolates(G1)
    versions["no_self_loops_no_isolates"] = graph_stats(G2)

    G3 = get_largest_component(G2)
    versions["no_self_loops_largest_component"] = graph_stats(G3)

    output_path = os.path.join(outdir, f"{label}_stats.json")
    with open(output_path, "w", encoding="utf-8") as f:
        json.dump(versions, f, indent=2)

    print(f"Saved stats for {label} → {output_path}")


def plot_degree_distributions(stats_file: str, output_dir: str = "graph_stats/plots") -> None:
    """
    Plot degree, in-degree, and out-degree distributions for all variants in a stats JSON file.
    """
    os.makedirs(output_dir, exist_ok=True)

    with open(stats_file, "r", encoding="utf-8") as f:
        stats = json.load(f)

    label = os.path.basename(stats_file).replace("_stats.json", "")

    def plot_distribution(dist_dict, title, filename):
        degrees = list(map(int, dist_dict.keys()))
        counts = list(dist_dict.values())

        plt.figure(figsize=(8, 5))
        plt.bar(degrees, counts, color="steelblue")
        plt.title(title)
        plt.xlabel("Degree")
        plt.ylabel("Node Count")
        plt.tight_layout()
        plt.savefig(os.path.join(output_dir, filename))
        plt.close()

    for variant, data in stats.items():
        if "degree_distribution" in data:
            plot_distribution(
                data["degree_distribution"],
                f"{label} - {variant} - Degree Distribution",
                f"{label}_{variant}_degree_distribution.png"
            )
        if "in_degree_distribution" in data:
            plot_distribution(
                data["in_degree_distribution"],
                f"{label} - {variant} - In-Degree Distribution",
                f"{label}_{variant}_in_degree_distribution.png"
            )
        if "out_degree_distribution" in data:
            plot_distribution(
                data["out_degree_distribution"],
                f"{label} - {variant} - Out-Degree Distribution",
                f"{label}_{variant}_out_degree_distribution.png"
            )

    print(f"Plots saved to {output_dir} for {label}")


def compute_centrality_metrics(
    gexf_file: str = None,
    output_csv: str = None,
    graph: nx.Graph = None
) -> None:
    """
    Compute and export degree, betweenness, and eigenvector centrality metrics.
    """
    if graph is None:
        if not gexf_file:
            raise ValueError("Must provide either graph or gexf_file.")
        G = nx.read_gexf(gexf_file)
    else:
        G = graph

    # Convert multi-graphs if necessary
    if isinstance(G, nx.MultiDiGraph):
        G = nx.DiGraph((u, v, d) for u, v, d in G.edges(data=True))
    elif isinstance(G, nx.MultiGraph):
        G = nx.Graph((u, v, d) for u, v, d in G.edges(data=True))

    if output_csv is None:
        output_csv = gexf_file.replace(".gexf", "_centrality.csv")

    # Use largest (weakly) connected component for eigenvector
    cc_func = nx.weakly_connected_components if G.is_directed() else nx.connected_components
    G_sub = G.subgraph(max(cc_func(G), key=len)).copy()

    degree = nx.degree_centrality(G)
    betweenness = nx.betweenness_centrality(G, normalized=True)
    eigenvector = nx.eigenvector_centrality(G_sub, max_iter=3000)

    # Merge into dataframe
    data = []
    for node in G.nodes:
        data.append({
            "node": node,
            "degree_centrality": degree.get(node, 0),
            "betweenness_centrality": betweenness.get(node, 0),
            "eigenvector_centrality": eigenvector.get(node, "")
        })

    df = pd.DataFrame(data)
    df.to_csv(output_csv, index=False)
    print(f"Centrality metrics written to: {output_csv}")


def compute_filtered_and_save(graph_path: str, relation_filter: str = None, output_tag: str = "") -> None:
    """
    Load a GEXF graph and compute centrality metrics on a filtered version (by edge relation).
    """
    G = nx.read_gexf(graph_path)

    if relation_filter:
        G_filtered = nx.DiGraph()
        G_filtered.add_nodes_from(G.nodes(data=True))
        for u, v, data in G.edges(data=True):
            if data.get("relation") == relation_filter:
                G_filtered.add_edge(u, v, **data)
        suffix = f"_{relation_filter}" if not output_tag else f"_{output_tag}"
    else:
        G_filtered = G
        suffix = f"_{output_tag}" if output_tag else "_all"

    output_csv = graph_path.replace(".gexf", f"{suffix}_centrality.csv")
    compute_centrality_metrics(graph=G_filtered, output_csv=output_csv)


def generate_temporal_snapshots(
    graph: nx.Graph,
    mode: str = "edges",
    snapshot_size: int = 1,
    rolling: bool = False,
    output_dir: str = "snapshots",
    remove_isolates: bool = True,
    largest_component_only: bool = False,
    save: bool = True
) -> list:
    """
    Generate and optionally save temporal subgraphs sliced by year in windows.

    Returns:
        List of (start_year, end_year, snapshot_graph)
    """
    assert mode in {"edges", "nodes"}
    os.makedirs(output_dir, exist_ok=True)

    if mode == "edges":
        years = sorted({d["year"] for _, _, d in graph.edges(data=True) if "year" in d})
    else:
        years = sorted({d["year"] for _, d in graph.nodes(data=True) if "year" in d})

    if not years:
        raise ValueError("No valid year attributes found.")

    snapshots = [(start, start + snapshot_size) for start in range(min(years), max(years) + 1, snapshot_size)]
    results = []

    for start, end in snapshots:
        if mode == "edges":
            G_sub = graph.__class__()
            G_sub.add_nodes_from(graph.nodes(data=True))
            for u, v, data in graph.edges(data=True):
                y = data.get("year")
                if y is None or u == v:
                    continue
                if start <= y < end or (rolling and y < end):
                    G_sub.add_edge(u, v, **data)
        else:
            nodes = [
                n for n, d in graph.nodes(data=True)
                if start <= d.get("year", -1) < end or (rolling and d.get("year", -1) < end)
            ]
            G_sub = graph.subgraph(nodes).copy()
            G_sub.remove_edges_from(nx.selfloop_edges(G_sub))

        if remove_isolates:
            G_sub.remove_nodes_from(list(nx.isolates(G_sub)))

        if largest_component_only and G_sub.number_of_nodes() > 0:
            cc_func = nx.weakly_connected_components if G_sub.is_directed() else nx.connected_components
            G_sub = G_sub.subgraph(max(cc_func(G_sub), key=len)).copy()

        if save:
            file = os.path.join(output_dir, f"{mode}_snapshot_{start}_{end}.gexf")
            nx.write_gexf(G_sub, file)
            print(f"Saved: {file} ({G_sub.number_of_nodes()} nodes, {G_sub.number_of_edges()} edges)")

        results.append((start, end, G_sub))

    return results


def main():
    """
    Run full graph analysis pipeline over multiple precomputed GEXF graphs.
    """
    graph_files = {
        "semantic_reachability": "mto_semantic_reachability.gexf",
        "citations": "mto_citations.gexf",
        "author_interactions": "mto_author_interactions.gexf",
        "temporal_keyword": "mto_temporal_keyword_graph.gexf",
        "keyword_links": "mto_article_keyword_links.gexf",
        "author_interactions_collapsed": "mto_author_interactions_collapsed.gexf",
    }

    for label, path in graph_files.items():
        print(f"\n📂 Analyzing: {path}")
        G = nx.read_gexf(path)
        analyze_graph_versions(G, label=label)
        plot_degree_distributions(f"graph_stats/{label}_stats.json")

    base = "mto_author_interactions_collapsed.gexf"
    compute_filtered_and_save(base)
    compute_filtered_and_save(base, relation_filter="collaboration")
    compute_filtered_and_save(base, relation_filter="citation")

    G = nx.read_gexf(base)
    generate_temporal_snapshots(
        graph=G,
        mode="edges",
        snapshot_size=5,
        rolling=True,
        output_dir="snapshots",
        remove_isolates=True,
        largest_component_only=False
    )


if __name__ == "__main__":
    main()