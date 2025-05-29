import os
import networkx as nx
import pandas as pd
import matplotlib.pyplot as plt
from stats import generate_temporal_snapshots

from importlib import reload
import stats
reload(stats)

# Maps each graph file to the temporal slicing mode ("edges" or "nodes")
graphs_and_modes = {
    "mto_author_interactions.gexf": "edges",
    "mto_author_interactions_collapsed.gexf": "edges",
    "mto_article_keyword_links.gexf": "nodes", 
    "mto_semantic_reachability.gexf": "nodes",
    "mto_citations.gexf": "nodes",
    "mto_temporal_keyword_graph.gexf": "nodes"
}


def truncate_label(text: str, max_words: int = 5) -> str:
    """
    Shorten long text labels to a limited number of words for plotting.
    """
    words = text.strip().split()
    return " ".join(words[:max_words]) + "…" if len(words) > max_words else text


def compute_centrality_metrics(
    gexf_file: str = None,
    output_csv: str = None,
    graph: nx.Graph = None
) -> None:
    """
    Compute centrality metrics (degree, betweenness, eigenvector) for a graph.

    Args:
        gexf_file: Optional path to input GEXF file (used if graph is not provided)
        output_csv: Path to save centrality metrics CSV
        graph: Pre-loaded NetworkX graph (takes precedence over gexf_file)
    """
    if graph is None:
        if not gexf_file:
            raise ValueError("Must provide either graph or gexf_file.")
        G = nx.read_gexf(gexf_file)
    else:
        G = graph

    is_directed = G.is_directed()
    print(f"Computing centrality metrics for {'Directed' if is_directed else 'Undirected'} graph with {G.number_of_nodes()} nodes...")

    if output_csv is None:
        if not gexf_file:
            raise ValueError("Must specify output_csv if no gexf_file is given.")
        output_csv = gexf_file.replace(".gexf", "_centrality.csv")

    # Compute full-graph degree centrality
    degree_centrality = nx.degree_centrality(G)

    # Extract largest (weakly) connected component for more stable eigenvector computation
    cc_func = nx.weakly_connected_components if is_directed else nx.connected_components
    largest_cc = max(cc_func(G), key=len)
    G_sub = G.subgraph(largest_cc).copy()

    # Simplify if MultiGraph
    if isinstance(G_sub, (nx.MultiGraph, nx.MultiDiGraph)):
        cls = nx.DiGraph if G_sub.is_directed() else nx.Graph
        G_simple = cls()
        G_simple.add_nodes_from(G_sub.nodes(data=True))
        G_simple.add_edges_from((u, v, d) for u, v, d in G_sub.edges(data=True))
    else:
        G_simple = G_sub

    # Compute centralities
    betweenness_centrality = nx.betweenness_centrality(G_simple, normalized=True)
    try:
        eigenvector_centrality = nx.eigenvector_centrality(G_simple, max_iter=1000)
    except nx.PowerIterationFailedConvergence:
        eigenvector_centrality = {}

    # Assemble results
    rows = []
    for node in G.nodes:
        rows.append({
            "node": node,
            "degree_centrality": degree_centrality.get(node, 0),
            "betweenness_centrality": betweenness_centrality.get(node, 0),
            "eigenvector_centrality": eigenvector_centrality.get(node, "")
        })

    pd.DataFrame(rows).to_csv(output_csv, index=False)
    print(f"Centrality metrics written to: {output_csv}")


def run_centrality_over_time(
    graph_path: str,
    snapshot_mode: str = "edges",
    snapshot_size: int = 3,
    rolling: bool = True,
    remove_isolates: bool = True,
    largest_component_only: bool = False,
    output_dir: str = "centrality_snapshots"
) -> tuple[pd.DataFrame, str, nx.Graph]:
    """
    Compute temporal snapshots and centrality metrics for a graph over time.

    Args:
        graph_path: Path to the full graph GEXF file
        snapshot_mode: "edges" or "nodes" for time attribution
        snapshot_size: Window size (in years)
        rolling: If True, snapshots include data from earlier windows
        remove_isolates: Whether to drop isolates in each snapshot
        largest_component_only: Whether to retain only largest component
        output_dir: Root folder to store outputs

    Returns:
        Tuple of (combined_df, snapshot_dir_path, original_graph)
    """
    G = nx.read_gexf(graph_path)
    graph_name = os.path.splitext(os.path.basename(graph_path))[0]
    snapshot_dir = os.path.join(output_dir, graph_name)
    os.makedirs(snapshot_dir, exist_ok=True)

    snapshots = generate_temporal_snapshots(
        graph=G,
        mode=snapshot_mode,
        snapshot_size=snapshot_size,
        rolling=rolling,
        remove_isolates=remove_isolates,
        largest_component_only=largest_component_only,
        save=False
    )

    all_dfs = []
    for start, end, subgraph in snapshots:
        label = f"{start}_{end}"
        print(f"\nComputing centrality for {graph_name} [{label}]...")
        csv_path = os.path.join(snapshot_dir, f"centrality_{label}.csv")
        compute_centrality_metrics(graph=subgraph, output_csv=csv_path)

        df = pd.read_csv(csv_path)
        df["interval_start"] = start
        df["interval_end"] = end
        all_dfs.append(df)

    combined_df = pd.concat(all_dfs, ignore_index=True)
    combined_csv = os.path.join(snapshot_dir, "centrality_over_time.csv")
    combined_df.to_csv(combined_csv, index=False)
    print(f"Combined centrality trends saved to: {combined_csv}")

    return combined_df, snapshot_dir, G


def plot_centrality_trends(
    df: pd.DataFrame,
    metric: str,
    output_dir: str,
    graph: nx.Graph,
    top_n: int = 10
) -> None:
    """
    Plot time series of top-n nodes by average centrality.

    Args:
        df: DataFrame with centrality metrics over time
        metric: Column name of centrality to plot
        output_dir: Directory to save plot
        graph: Original graph (used for node labels)
        top_n: Number of top nodes to display
    """
    os.makedirs(output_dir, exist_ok=True)

    # Pivot to: index = time, columns = node, values = centrality
    pivoted = df.pivot_table(index=["interval_start", "interval_end"], columns="node", values=metric, fill_value=0)
    mean_scores = pivoted.mean(axis=0)
    top_nodes = mean_scores.sort_values(ascending=False).head(top_n).index

    plt.figure(figsize=(10, 6))

    for node in top_nodes:
        node_data = graph.nodes.get(node, {})
        label = node_data.get("title") or node_data.get("label") or node
        if "authors" in node_data:
            label = f"{node_data['authors']}: {label}"
        plt.plot(pivoted.index.get_level_values(0), pivoted[node], marker='o', label=truncate_label(str(label)))

    # take part after \ of output_dir and split on _
    graph_name = " ".join(os.path.basename(output_dir).split("_"))

    plt.title(f"{graph_name}: Top {top_n} by {metric.replace('_', ' ').title()} Over Time")
    plt.xlabel("Start Year of Snapshot")
    plt.ylabel(metric.replace("_", " ").title())
    plt.legend(bbox_to_anchor=(1.05, 1), loc="upper left")
    plt.tight_layout()

    plot_path = os.path.join(output_dir, f"{metric}_trend.png")
    plt.savefig(plot_path)
    print(f"Plot saved: {plot_path}")
    plt.close()


if __name__ == "__main__":
    for graph_file, mode in graphs_and_modes.items():
        df, snapshot_dir, G = run_centrality_over_time(
            graph_path=graph_file,
            snapshot_mode=mode
        )
        for metric in ["degree_centrality", "betweenness_centrality", "eigenvector_centrality"]:
            plot_centrality_trends(df, metric, output_dir=snapshot_dir, graph=G)
