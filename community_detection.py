import os
import networkx as nx
import pandas as pd
import matplotlib.pyplot as plt
from stats import generate_temporal_snapshots
from infomap import Infomap

def track_communities_over_time(
    gexf_filename,
    window_size=5,
    rolling=False,
    output_filename=None,
    mode="edges",
    remove_isolates=True,
    largest_component_only=False
):
    """
    Track communities across temporal snapshots using the Infomap algorithm.

    Parameters:
        gexf_filename: Path to the input GEXF file
        window_size: Time window size in years for each snapshot
        rolling: Whether to use rolling accumulation for edges/nodes
        output_filename: Optional name for output CSV with community labels
        mode: 'edges' or 'nodes' — determines how temporal snapshots are sliced
        remove_isolates: Whether to drop isolated nodes from each snapshot
        largest_component_only: Whether to restrict each snapshot to its largest connected component

    Returns:
        DataFrame of node-to-community assignments over time
    """
    base_name = os.path.splitext(os.path.basename(gexf_filename))[0]

    node_comm_dir = os.path.join("communities", "node_communities")
    stats_dir = os.path.join("communities", "community_stats")
    plots_dir = os.path.join("communities", "community_plots")
    for d in [node_comm_dir, stats_dir, plots_dir]:
        os.makedirs(d, exist_ok=True)

    if output_filename is None:
        output_filename = os.path.join(node_comm_dir, f"{base_name}_communities.csv")
    else:
        output_filename = os.path.join(node_comm_dir, output_filename)

    print(f"Loading graph from: {gexf_filename}")
    G = nx.read_gexf(gexf_filename)
    snapshots = generate_temporal_snapshots(
        graph=G,
        mode=mode,
        snapshot_size=window_size,
        rolling=rolling,
        output_dir="snapshots",
        remove_isolates=remove_isolates,
        largest_component_only=largest_component_only,
        save=False
    )

    print(f"Generated {len(snapshots)} temporal snapshots")

    all_nodes = set()
    for _, _, G_snap in snapshots:
        all_nodes.update(G_snap.nodes())
    all_nodes = sorted(all_nodes)
    node_to_int = {node: i for i, node in enumerate(all_nodes)}
    int_to_node = {i: node for node, i in node_to_int.items()}

    columns = [f"{start}_{end}" for start, end, _ in snapshots]
    df = pd.DataFrame(index=all_nodes, columns=columns)
    stat_records = []

    for (start, end, G_snap), col in zip(snapshots, columns):
        print(f"Processing snapshot {start}-{end}...")
        if G_snap.number_of_nodes() == 0 or G_snap.number_of_edges() == 0:
            print("Skipping empty snapshot")
            continue
        im = Infomap(silent=True)
        for u, v in G_snap.edges():
            im.add_link(int(node_to_int[u]), int(node_to_int[v]))
        im.run()

        node2comm = {int_to_node[node.node_id]: node.module_id for node in im.tree if node.is_leaf}
        for node in G_snap.nodes():
            df.at[node, col] = node2comm.get(node, None)

        sizes = pd.Series(list(node2comm.values())).value_counts()
        stat_records.append({
            "start": start,
            "end": end,
            "num_communities": sizes.size,
            "mean_size": sizes.mean(),
            "max_size": sizes.max()
        })

    df.to_csv(output_filename)
    print(f"Node-community assignments written to: {output_filename}")

    stats_df = pd.DataFrame(stat_records)
    stats_path = os.path.join(stats_dir, f"{base_name}_community_stats.csv")
    stats_df.to_csv(stats_path, index=False)
    print(f"Community stats written to: {stats_path}")

    plt.figure(figsize=(10, 5))
    plt.plot(stats_df["start"], stats_df["num_communities"], marker='o', label="Number of communities")
    plt.plot(stats_df["start"], stats_df["mean_size"], marker='s', label="Mean community size")
    plt.plot(stats_df["start"], stats_df["max_size"], marker='^', label="Max community size")
    plt.xlabel("Start year of snapshot")
    plt.ylabel("Metric")
    plt.title(f"Community Structure Over Time: {base_name}")
    plt.legend()
    plt.grid(True)
    plt.tight_layout()
    plot_path = os.path.join(plots_dir, f"{base_name}_community_stats.png")
    plt.savefig(plot_path)
    plt.close()
    print(f"Community stats plot saved to: {plot_path}")

    return df

def main():
    graphs_and_modes = {
        "mto_author_interactions.gexf": "edges",
        "mto_author_interactions_collapsed.gexf": "edges",
        "mto_article_keyword_links.gexf": "nodes",
        "mto_semantic_reachability.gexf": "nodes",
        "mto_citations.gexf": "nodes",
        "mto_temporal_keyword_graph.gexf": "nodes"
    }

    for gexf, mode in graphs_and_modes.items():
        print(f"Running community tracking on: {gexf} (mode: {mode})")
        track_communities_over_time(
            gexf_filename=gexf,
            window_size=5,
            rolling=True,
            output_filename=None,
            mode=mode,
            remove_isolates=True,
            largest_component_only=False
        )

if __name__ == "__main__":
    main()
