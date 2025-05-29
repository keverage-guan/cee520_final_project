import json
import os
import numpy as np
import pandas as pd
from collections import defaultdict, Counter
from sklearn.metrics.pairwise import cosine_distances
from sklearn.preprocessing import normalize
from sklearn.decomposition import PCA
import matplotlib.pyplot as plt

KEYWORDS_PATH = "mto_keywords.json"
STOPWORDS_PATH = "stopwords.txt"
MIN_YEAR = 1993
MAX_YEAR = 2025
MIN_GLOBAL_COUNT = 5
WINDOW_SIZE = 5

def load_keywords(path=KEYWORDS_PATH):
    print("Loading keywords from:", path)
    with open(path, "r", encoding="utf-8") as f:
        return json.load(f)

def load_stopwords(path=STOPWORDS_PATH):
    print("Loading stopwords from:", path)
    with open(path, "r", encoding="utf-8") as f:
        return set(line.strip().lower() for line in f if line.strip())

def get_time_windows(start=MIN_YEAR, end=MAX_YEAR, window=WINDOW_SIZE):
    return [(y, y + window - 1) for y in range(start, end + 1, window)]

def assign_window(year, window_size=WINDOW_SIZE):
    base = ((year - MIN_YEAR) // window_size) * window_size + MIN_YEAR
    return f"{base}-{base + window_size - 1}"

def build_keyword_window_cooccurrence(keywords_data, stopwords):
    print("Building keyword co-occurrence counts...")
    cooccur = defaultdict(lambda: defaultdict(Counter))
    vocab = Counter()

    for article in keywords_data:
        year = article.get("year")
        if not isinstance(year, int):
            continue
        window_label = assign_window(year)
        kws = [kw.lower().strip() for kw in article.get("keywords", []) if kw.lower().strip() not in stopwords]
        kws = list(set(kws))
        for kw in kws:
            vocab[kw] += 1
            for other in kws:
                if kw != other:
                    cooccur[kw][window_label][other] += 1
    print("Finished building co-occurrence structure.")
    return cooccur, vocab

def cooccurrence_vectors(cooccur, vocab, min_count=MIN_GLOBAL_COUNT):
    print("Constructing normalized co-occurrence vectors...")
    vocab_list = sorted([w for w, c in vocab.items() if c >= min_count])
    vocab_index = {w: i for i, w in enumerate(vocab_list)}
    drift_vectors = {}

    for kw in vocab_list:
        drift_vectors[kw] = {}
        for window_label in cooccur[kw]:
            vec = np.zeros(len(vocab_list))
            for other_kw, count in cooccur[kw][window_label].items():
                if other_kw in vocab_index:
                    vec[vocab_index[other_kw]] = count
            vec = normalize(vec.reshape(1, -1), norm="l2")[0]
            drift_vectors[kw][window_label] = vec

    print("Co-occurrence vectors generated.")
    return drift_vectors, vocab_list

def compute_drift_scores(drift_vectors):
    print("Computing drift scores...")
    drift_scores = []
    for kw, window_vectors in drift_vectors.items():
        windows = sorted(window_vectors.keys())
        total_drift = 0
        distances = []
        for i in range(1, len(windows)):
            prev = window_vectors[windows[i-1]]
            curr = window_vectors[windows[i]]
            d = cosine_distances([prev], [curr])[0][0]
            distances.append((windows[i-1], windows[i], d))
            total_drift += d
        drift_scores.append({
            "keyword": kw,
            "drift_total": total_drift,
            "distances": distances
        })
    print("Drift scores computed.")
    return pd.DataFrame(drift_scores).sort_values("drift_total", ascending=False)

def compute_pca_trajectories(drift_vectors):
    print("Computing PCA trajectories...")
    records = []
    vectors = []
    for kw in drift_vectors:
        for window, vec in drift_vectors[kw].items():
            records.append((kw, window))
            vectors.append(vec)

    if not vectors:
        print("No vectors to compute PCA on.")
        return pd.DataFrame()

    X = np.vstack(vectors)
    pca = PCA(n_components=2)
    X_2d = pca.fit_transform(X)

    df = pd.DataFrame(X_2d, columns=["x", "y"])
    df["keyword"] = [kw for kw, _ in records]
    df["window"] = [w for _, w in records]
    print("PCA trajectories computed.")
    return df

def plot_keyword_drift(keyword, distances, output_dir="semantic_drift_plots"):
    os.makedirs(output_dir, exist_ok=True)
    x_labels = [f"{a}→{b}" for a, b, _ in distances]
    y_vals = [d for _, _, d in distances]
    plt.figure(figsize=(10, 4))
    plt.plot(x_labels, y_vals, marker='o', linewidth=2)
    plt.title(f"Semantic Drift of '{keyword}'")
    plt.xlabel("Time Window Transition")
    plt.ylabel("Cosine Distance")
    plt.xticks(rotation=45)
    plt.grid(True)
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, f"{keyword.replace(' ', '_')}_drift.png"))
    plt.close()
    print(f"Drift plot saved for '{keyword}'")

def plot_pca_trajectories(df, target_keywords, output_dir="semantic_drift_plots", show_labels=True, filename="semantic_trajectories_pca.png"):
    os.makedirs(output_dir, exist_ok=True)
    plt.figure(figsize=(10, 8))
    for kw in target_keywords:
        points = df[df["keyword"] == kw].sort_values("window")
        if len(points) < 2:
            continue
        plt.plot(points["x"], points["y"], marker='o', label=kw)
        if show_labels:
            plt.text(points.iloc[0]["x"], points.iloc[0]["y"], points.iloc[0]["window"], fontsize=7)
            plt.text(points.iloc[-1]["x"], points.iloc[-1]["y"], points.iloc[-1]["window"], fontsize=7)

    plt.title("Semantic Trajectories in PCA Space")
    plt.xlabel("PCA 1")
    plt.ylabel("PCA 2")
    plt.legend(fontsize=8, loc='best')
    plt.grid(True)
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, filename), bbox_inches="tight")
    plt.close()
    print(f"PCA trajectory plot saved to {filename}")

def plot_similar_trajectories(drift_vectors, reference_keyword, method="average", top_n=5, min_windows=3, output_dir="semantic_drift_plots"):
    if reference_keyword not in drift_vectors:
        print(f"Reference keyword '{reference_keyword}' not found.")
        return

    ref_traj = drift_vectors[reference_keyword]
    matches = []

    for kw, vec_map in drift_vectors.items():
        if kw == reference_keyword:
            continue
        common_windows = sorted(set(ref_traj) & set(vec_map))
        if len(common_windows) < min_windows:
            continue
        ref_vecs = np.vstack([ref_traj[w] for w in common_windows])
        cand_vecs = np.vstack([vec_map[w] for w in common_windows])
        dists = np.linalg.norm(ref_vecs - cand_vecs, axis=1)
        score = np.mean(dists) if method == "average" else np.max(dists)
        matches.append((kw, score))

    matches.sort(key=lambda x: x[1])
    top_matches = [reference_keyword] + [kw for kw, _ in matches[:top_n]]

    df = compute_pca_trajectories({kw: drift_vectors[kw] for kw in top_matches})
    plot_pca_trajectories(df, top_matches, output_dir=output_dir, show_labels=True, filename=f"similar_to_{reference_keyword}.png")

if __name__ == "__main__":
    print("Loading keyword and stopword data...")
    data = load_keywords()
    stopwords = load_stopwords()

    print("Building co-occurrence structure using fixed windows...")
    cooccur, vocab = build_keyword_window_cooccurrence(data, stopwords)

    print("Creating normalized co-occurrence vectors...")
    drift_vectors, vocab_list = cooccurrence_vectors(cooccur, vocab)

    print("Computing drift scores...")
    drift_df = compute_drift_scores(drift_vectors)
    drift_df.to_csv("keyword_drift_scores.csv", index=False)
    print("Drift scores saved to keyword_drift_scores.csv")

    top_common = sorted(vocab.items(), key=lambda x: -x[1])[:50]
    target_keywords = [kw for kw, _ in top_common]

    for kw in target_keywords[:10]:
        match = drift_df[drift_df["keyword"] == kw]
        if not match.empty:
            row = match.iloc[0]
            plot_keyword_drift(row["keyword"], row["distances"])

    df = compute_pca_trajectories(drift_vectors)
    plot_pca_trajectories(df, target_keywords, show_labels=False, filename="semantic_trajectories_pca.png")

    reference_keywords = ['pop', 'rock', 'jazz', 'beethoven', 'counterpoint']
    for ref_kw in reference_keywords:
        plot_similar_trajectories(drift_vectors, ref_kw, method="average", top_n=5, min_windows=5, output_dir="semantic_drift_plots")
