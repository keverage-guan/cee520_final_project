import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import glob
import os

def load_all_embeddings(folder: str = "node2vec_embeddings") -> pd.DataFrame:
    """
    Load all Node2Vec embedding CSVs from a directory (excluding the full graph).

    Parameters:
        folder: Directory containing node2vec_*.csv files

    Returns:
        Combined DataFrame of all embeddings from temporal snapshots.
    """
    files = glob.glob(os.path.join(folder, "node2vec_*.csv"))
    dfs = [pd.read_csv(f) for f in files if "full" not in f]
    print(f"Loaded {len(dfs)} embedding files from {folder}")
    return pd.concat(dfs, ignore_index=True)

def compute_author_drift(df: pd.DataFrame) -> pd.DataFrame:
    """
    Compute total Euclidean drift for each author based on their movement in embedding space across time.

    Parameters:
        df: DataFrame with Node2Vec embeddings (must contain x0, x1, snapshot, and author_id)

    Returns:
        DataFrame summarizing total drift, number of snapshots, and segment-level distances for each author.
    """
    df = df.sort_values(by=["author_id", "snapshot"])
    drift_records = []

    for author_id, group in df.groupby("author_id"):
        coords = group[["x0", "x1"]].values
        snapshots = group["snapshot"].values
        drift_total = 0
        drift_path = []
        for i in range(1, len(coords)):
            d = np.linalg.norm(coords[i] - coords[i-1])
            drift_total += d
            drift_path.append((snapshots[i-1], snapshots[i], d))
        drift_records.append({
            "author_id": author_id,
            "drift_total": drift_total,
            "snapshot_count": len(coords),
            "drift_path": drift_path
        })

    print(f"Computed drift for {len(drift_records)} authors")
    return pd.DataFrame(drift_records)

def plot_author_trajectory(df: pd.DataFrame, author_id: str) -> None:
    """
    Plot the 2D trajectory of a given author over time in embedding space.

    Parameters:
        df: DataFrame with Node2Vec embeddings (including x0, x1, snapshot, and author_id)
        author_id: ID of the author to plot
    """
    points = df[df["author_id"] == author_id].sort_values("snapshot")
    if points.empty:
        print(f"No embedding data found for author {author_id}")
        return

    plt.figure(figsize=(6, 5))
    plt.plot(points["x0"], points["x1"], marker='o')
    for _, row in points.iterrows():
        plt.text(row["x0"], row["x1"], row["snapshot"], fontsize=8)
    plt.title(f"Discourse Trajectory: {author_id}")
    plt.xlabel("x0")
    plt.ylabel("x1")
    plt.grid(True)
    plt.tight_layout()
    plt.show()
    print(f"Trajectory plot completed for author {author_id}")

if __name__ == "__main__":
    print("Loading all Node2Vec embeddings...")
    embeddings = load_all_embeddings()

    print("Computing author drift metrics...")
    drift_df = compute_author_drift(embeddings)
    drift_df.to_csv("author_drift_summary.csv", index=False)
    print("Drift summary saved to author_drift_summary.csv")

    # Example: plot trajectory of the author with the largest total drift
    top_drifter = drift_df.sort_values("drift_total", ascending=False).iloc[0]["author_id"]
    print(f"Top drifter: {top_drifter}")
    plot_author_trajectory(embeddings, top_drifter)
