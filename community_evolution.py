import pandas as pd
import os
import json
from collections import defaultdict
from itertools import product
import matplotlib.pyplot as plt
import random
import plotly.graph_objects as go

def jaccard(a, b):
    return len(a & b) / len(a | b) if a | b else 0

def track_community_evolution(
    filepath,
    thresholds,
    priority=("survive", "split", "death", "merge", "birth"),
    include_single_window_communities=True,
    label_strategy="most_present",  # Options: "random", "alphabetical", "most_present"
    top_k=3
):
    df = pd.read_csv(filepath, index_col=0)
    snapshots = df.columns.tolist()
    events = []

    base = os.path.splitext(os.path.basename(filepath))[0].replace("_communities", "")
    output_dir = os.path.join("communities", "community_evolution", base)
    os.makedirs(output_dir, exist_ok=True)

    output_csv = os.path.join(output_dir, f"{base}_evolution.csv")
    count_json = os.path.join(output_dir, f"{base}_event_counts.json")
    plot_path = os.path.join(output_dir, f"{base}_event_plot.png")
    meta_json = os.path.join(output_dir, f"{base}_community_lifespans.json")

    lifespans = {}
    members_over_time = defaultdict(list)
    members_over_time_counts = defaultdict(lambda: defaultdict(int))

    initial_col = snapshots[0]
    initial_comms = defaultdict(set)
    for node, comm in df[initial_col].dropna().items():
        comm_id = f"{initial_col}_C{int(comm)}"
        initial_comms[comm_id].add(node)
    for comm_id, members in initial_comms.items():
        events.append({"time": initial_col, "type": "birth", "source": None, "target": comm_id, "score": None})
        lifespans[comm_id] = {"start_time": initial_col, "start_type": "birth"}
        members_over_time[comm_id].append(set(members))
        for m in members:
            members_over_time_counts[comm_id][m] += 1

    for t in range(len(snapshots) - 1):
        col_a, col_b = snapshots[t], snapshots[t + 1]
        time = col_b

        comms_a = defaultdict(set)
        comms_b = defaultdict(set)

        for node, comm in df[col_a].dropna().items():
            comms_a[f"{col_a}_C{int(comm)}"].add(node)
        for node, comm in df[col_b].dropna().items():
            comms_b[f"{col_b}_C{int(comm)}"].add(node)

        sim = {}
        for a, b in product(comms_a, comms_b):
            score = jaccard(comms_a[a], comms_b[b])
            if score > 0:
                sim[(a, b)] = score

        used_a = set()

        for rule in priority:
            if rule not in {"merge", "birth"}:
                th = thresholds.get(rule, 0.0)

            if rule == "survive":
                for a in comms_a:
                    if a in used_a:
                        continue
                    matches = [(b, s) for (x, b), s in sim.items() if x == a and s >= th]
                    if len(matches) == 1:
                        b, s = matches[0]
                        events.append({"time": time, "type": "survive", "source": a, "target": b, "score": s})
                        used_a.add(a)
                        lifespans[b] = lifespans[a]
                        members_over_time[b] = members_over_time[a] + [comms_b[b]]
                        members_over_time_counts[b] = members_over_time_counts[a].copy()
                        for m in comms_b[b]:
                            members_over_time_counts[b][m] += 1
                        del lifespans[a]

            elif rule == "split":
                for a in comms_a:
                    if a in used_a:
                        continue
                    matches = [(b, s) for (x, b), s in sim.items() if x == a and s >= th]
                    if len(matches) >= 2:
                        targets = [b for b, _ in matches]
                        scores = [s for _, s in matches]
                        events.append({"time": time, "type": "split", "source": a, "target": targets, "score": scores})
                        lifespans[a]["end_time"] = time
                        lifespans[a]["end_type"] = "split"
                        lifespans[a]["split_targets"] = targets
                        used_a.add(a)

            elif rule == "death":
                for a in comms_a:
                    if a not in used_a:
                        events.append({"time": time, "type": "death", "source": a, "target": None, "score": None})
                        lifespans[a]["end_time"] = time
                        lifespans[a]["end_type"] = "death"

        for rule in priority:
            if rule == "merge":
                th = thresholds.get("merge", 0.0)
                for b in comms_b:
                    matches = [(a, s) for (a, y), s in sim.items() if y == b and s >= th]
                    if len(matches) >= 2:
                        sources = [a for a, _ in matches]
                        scores = [s for _, s in matches]
                        events.append({"time": time, "type": "merge", "source": sources, "target": b, "score": scores})
                        lifespans[b] = {
                            "start_time": time,
                            "start_type": "merge",
                            "merge_sources": sources
                        }
                        members_over_time[b].append(comms_b[b])
                        for m in comms_b[b]:
                            members_over_time_counts[b][m] += 1

            elif rule == "birth":
                used_targets = {
                    e["target"]
                    for e in events
                    if e["time"] == time and e["type"] in {"survive", "merge"}
                }
                for b in comms_b:
                    if b not in used_targets:
                        events.append({"time": time, "type": "birth", "source": None, "target": b, "score": None})
                        lifespans[b] = {"start_time": time, "start_type": "birth"}
                        members_over_time[b].append(comms_b[b])
                        for m in comms_b[b]:
                            members_over_time_counts[b][m] += 1

    cleaned_lifespans = {}
    for comm_id in lifespans:
        sets = members_over_time.get(comm_id, [])
        counts = members_over_time_counts.get(comm_id, {})
        num_windows = len(sets)
        lifespans[comm_id]["num_windows"] = max(1, num_windows)
        lifespans[comm_id]["member_window_counts"] = dict(sorted(counts.items()))

        if label_strategy == "random":
            candidates = list(counts.keys())
            lifespans[comm_id]["label_authors"] = random.sample(candidates, min(top_k, len(candidates)))
        elif label_strategy == "alphabetical":
            lifespans[comm_id]["label_authors"] = sorted(counts.keys())[:top_k]
        elif label_strategy == "most_present":
            top = sorted(counts.items(), key=lambda x: (-x[1], x[0]))[:top_k]
            lifespans[comm_id]["label_authors"] = [m for m, _ in top]
        else:
            lifespans[comm_id]["label_authors"] = []

        if include_single_window_communities or lifespans[comm_id]["num_windows"] > 1:
            cleaned_lifespans[comm_id] = lifespans[comm_id]

    pd.DataFrame(events).to_csv(output_csv, index=False)
    print(f"Saved community evolution events to: {output_csv}")

    with open(count_json, "w") as f:
        json.dump(pd.DataFrame(events).groupby(["time", "type"]).size().unstack(fill_value=0).to_dict("index"), f, indent=2)
    with open(meta_json, "w") as f:
        json.dump(cleaned_lifespans, f, indent=2)

    count_df = pd.DataFrame(events).groupby(["time", "type"]).size().unstack(fill_value=0)
    count_df.plot(kind="bar", stacked=True, figsize=(12, 6))
    graph_name = base.replace("_", " ")
    plt.title(f"{graph_name}: Community Evolution Events Over Time")
    plt.ylabel("Event Count")
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.savefig(plot_path)
    plt.close()
    print(f"Saved stacked bar chart of event types to: {plot_path}")

    return pd.DataFrame(events)

def main():
    input_dir = "communities/node_communities"
    thresholds = {"survive": 0.4, "split": 0.15, "merge": 0.15}

    for fname in os.listdir(input_dir):
        if not fname.endswith(".csv"):
            continue
        base = os.path.splitext(fname)[0].replace("_communities", "")
        print(f"Processing file: {fname}")
        track_community_evolution(
            filepath=os.path.join(input_dir, fname),
            thresholds=thresholds,
            include_single_window_communities=True,
            label_strategy="most_present",
            priority=("split", "merge", "survive", "death", "birth"),
            top_k=3
        )

if __name__ == "__main__":
    main()
