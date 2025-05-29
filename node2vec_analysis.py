import networkx as nx
import pandas as pd
from stats import generate_temporal_snapshots
from pathlib import Path
from node2vec import Node2Vec
from sklearn.decomposition import PCA
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns

def run_node2vec_embedding(
    G: nx.Graph,
    dimensions: int = 64,
    walk_length: int = 80,
    num_walks: int = 10,
    p: float = 1,
    q: float = 0.5,
    workers: int = 2,
    seed: int = 42,
    reduce_dim: int = 2
) -> pd.DataFrame:
    """
    Train Node2Vec on a graph and return a DataFrame of node embeddings.

    Parameters:
        G: NetworkX graph
        dimensions: Number of dimensions for initial embedding
        walk_length: Length of each random walk
        num_walks: Number of walks per node
        p: Return hyperparameter
        q: In-out hyperparameter
        workers: Number of parallel workers
        seed: Random seed
        reduce_dim: Reduce to this many dimensions using PCA (if < dimensions)

    Returns:
        DataFrame of embeddings (indexed by node)
    """
    print("Initializing Node2Vec...")
    node2vec = Node2Vec(
        G, dimensions=dimensions, walk_length=walk_length,
        num_walks=num_walks, p=p, q=q, workers=workers, seed=seed, quiet=True
    )

    print("Fitting embedding model...")
    model = node2vec.fit(window=10, min_count=1, batch_words=4)

    print("Extracting embeddings...")
    embeddings = np.array([model.wv[str(node)] for node in G.nodes()])
    node_ids = list(G.nodes())

    if reduce_dim and reduce_dim < dimensions:
        print(f"Reducing to {reduce_dim} dimensions using PCA...")
        pca = PCA(n_components=reduce_dim)
        embeddings = pca.fit_transform(embeddings)

    colnames = [f"x{i}" for i in range(embeddings.shape[1])]
    df = pd.DataFrame(embeddings, index=node_ids, columns=colnames)
    print("Node2Vec embeddings completed.")
    return df

def visualize_embedding(df: pd.DataFrame, title: str, output_file: str = None):
    """
    Create a scatterplot of 2D Node2Vec embeddings.

    Parameters:
        df: DataFrame containing x0, x1, and snapshot columns
        title: Plot title
        output_file: Optional path to save the figure
    """
    plt.figure(figsize=(8, 6))
    sns.scatterplot(data=df, x="x0", y="x1", hue="snapshot", s=20, palette="tab10")
    plt.title(title)
    plt.xlabel("x0")
    plt.ylabel("x1")
    plt.legend(bbox_to_anchor=(1.05, 1), loc='upper left')
    plt.tight_layout()
    if output_file:
        plt.savefig(output_file)
        print(f"Plot saved to {output_file}")
    else:
        plt.show()

def run_node2vec_on_snapshots(
    graph_path: str,
    snapshot_size: int = 3,
    output_dir: str = "node2vec_embeddings",
    plot_dir: str = "node2vec_plots"
):
    """
    Run Node2Vec on temporal snapshots of a graph and visualize the results.

    Parameters:
        graph_path: Path to input GEXF graph
        snapshot_size: Size of time window for snapshots
        output_dir: Directory to save embeddings
        plot_dir: Directory to save plots
    """
    Path(output_dir).mkdir(exist_ok=True)
    Path(plot_dir).mkdir(exist_ok=True)

    G_full = nx.read_gexf(graph_path).to_undirected()

    snapshots = generate_temporal_snapshots(
        graph=G_full,
        mode="edges",
        snapshot_size=snapshot_size,
        rolling=True,
        remove_isolates=True,
        largest_component_only=False,
        save=False,
        output_dir="unused"
    )

    all_dfs = []
    for start, end, G_snap in snapshots:
        if len(G_snap.nodes) < 10:
            print(f"Skipping {start}-{end} (too few nodes: {len(G_snap)})")
            continue
        df = run_node2vec_embedding(G_snap)
        df["snapshot"] = f"{start}-{end}"
        df["author_id"] = df.index
        df.to_csv(f"{output_dir}/node2vec_{start}_{end}.csv")
        print(f"Node2Vec embedding saved for {start}-{end}")
        visualize_embedding(df, title=f"Node2Vec Embedding {start}-{end}", output_file=f"{plot_dir}/node2vec_{start}_{end}.png")
        all_dfs.append(df)

    df_full = run_node2vec_embedding(G_full)
    df_full["snapshot"] = "full"
    df_full["author_id"] = df_full.index
    df_full.to_csv(f"{output_dir}/node2vec_full.csv")
    print(f"Node2Vec embedding on full graph saved to {output_dir}/node2vec_full.csv")
    visualize_embedding(df_full, title="Node2Vec Embedding Full", output_file=f"{plot_dir}/node2vec_full.png")
    all_dfs.append(df_full)

    combined_df = pd.concat(all_dfs, ignore_index=True)
    visualize_embedding(combined_df, title="Node2Vec Embeddings Over Time", output_file=f"{plot_dir}/node2vec_all_snapshots.png")

if __name__ == "__main__":
    run_node2vec_on_snapshots("mto_author_interactions.gexf")
