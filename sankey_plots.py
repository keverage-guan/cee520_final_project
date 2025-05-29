import json
import plotly.graph_objects as go
import os
import pandas as pd
import ast

def generate_sankey_from_lifespans(
    lifespans_path: str,
    labels_path: str,
    csv_path: str,
    output_path: str,
    include_births_and_deaths: bool = False
):
    """
    Generate a Sankey diagram to visualize community evolution using lifespans, labels, and event data.

    Parameters:
        lifespans_path: Path to JSON file with community lifespans
        labels_path: Path to JSON file with community labels
        csv_path: Path to CSV file with community evolution events
        output_path: Path to write the Sankey diagram HTML
        include_births_and_deaths: Whether to show virtual birth/death nodes in the diagram
    """
    with open(lifespans_path, 'r') as f:
        lifespans = json.load(f)
    with open(labels_path, 'r') as f:
        labels = json.load(f)
    df = pd.read_csv(csv_path)

    def format_label(comm_id):
        entry = labels.get(comm_id, {})
        label_str = ", ".join(entry.get("labels", []))
        return f"{comm_id}\n{label_str}" if label_str else comm_id

    label_map = {comm_id: format_label(comm_id) for comm_id in lifespans}
    node_sizes = {comm_id: labels.get(comm_id, {}).get("size", 1) for comm_id in lifespans}

    virtual_birth_node = "__BIRTH__"
    virtual_death_node = "__DEATH__"

    if include_births_and_deaths:
        node_sizes[virtual_birth_node] = 0
        node_sizes[virtual_death_node] = 0
        label_map[virtual_birth_node] = virtual_birth_node
        label_map[virtual_death_node] = virtual_death_node

    all_nodes = sorted(label_map.keys())
    label_to_index = {comm: i for i, comm in enumerate(all_nodes)}
    node_labels = [label_map[comm] for comm in all_nodes]
    node_thickness = [node_sizes.get(comm, 1) for comm in all_nodes]

    source_indices = []
    target_indices = []
    values = []
    hover_scores = []

    merge_scores = {}
    split_scores = {}

    for _, row in df.iterrows():
        typ = row["type"]
        score = row.get("score")

        if typ in {"merge", "split"} and score:
            if isinstance(score, str):
                try:
                    score_list = json.loads(score.replace("'", '"'))
                except Exception:
                    continue
            else:
                score_list = [score]

            try:
                sources = ast.literal_eval(row["source"]) if isinstance(row["source"], str) and row["source"].startswith("[") else [row["source"]]
                targets = ast.literal_eval(row["target"]) if isinstance(row["target"], str) and row["target"].startswith("[") else [row["target"]]
            except Exception:
                continue

            if typ == "merge":
                for (s, val) in zip(sources, score_list):
                    merge_scores[(s, row["target"])] = val
            elif typ == "split":
                for (t, val) in zip(targets, score_list):
                    split_scores[(row["source"], t)] = val

    for comm_id, data in lifespans.items():
        source_label = comm_id

        if data.get("end_type") == "split":
            for target in data.get("split_targets", []):
                val = split_scores.get((comm_id, target), 1)
                if target in label_to_index and source_label in label_to_index:
                    source_indices.append(label_to_index[source_label])
                    target_indices.append(label_to_index[target])
                    values.append(val)
                    hover_scores.append(round(val, 3))

        if data.get("start_type") == "merge":
            for source in data.get("merge_sources", []):
                val = merge_scores.get((source, comm_id), 1)
                if source in label_to_index and comm_id in label_to_index:
                    source_indices.append(label_to_index[source])
                    target_indices.append(label_to_index[comm_id])
                    values.append(val)
                    hover_scores.append(round(val, 3))

        if include_births_and_deaths and data.get("start_type") == "birth":
            source_indices.append(label_to_index[virtual_birth_node])
            target_indices.append(label_to_index[comm_id])
            values.append(1)

        if include_births_and_deaths and data.get("end_type") == "death":
            source_indices.append(label_to_index[comm_id])
            target_indices.append(label_to_index[virtual_death_node])
            values.append(1)

    fig = go.Figure(data=[go.Sankey(
        node=dict(
            pad=20,
            thickness=20,
            line=dict(color="black", width=0.5),
            label=node_labels,
            customdata=[f"Size: {node_sizes.get(n, 1)}" for n in all_nodes],
            hovertemplate="%{label}<br>%{customdata}<extra></extra>"
        ),
        link=dict(
            source=source_indices,
            target=target_indices,
            value=values,
            customdata=hover_scores,
            hovertemplate="Jaccard: %{customdata}<extra></extra>"
        )
    )])

    base = csv_path.split("\\")[-1].replace("_evolution.csv", "").replace("_", " ")

    fig.update_layout(title_text=f"{base}: Community Evolution Sankey Diagram", font_size=11)
    fig.write_html(output_path)
    print(f"Saved Sankey diagram to {output_path}")

def main():
    """
    Generate Sankey diagrams (with and without births/deaths) for multiple datasets.
    """
    graphs = [
        "mto_citations",
        "mto_semantic_reachability",
        "mto_temporal_keyword_graph",
        "mto_author_interactions",
        "mto_author_interactions_collapsed",
        "mto_article_keyword_links"
    ]

    for base in graphs:
        dir_path = f"communities/community_evolution/{base}"
        lifespans_path = os.path.join(dir_path, f"{base}_community_lifespans.json")
        labels_path = os.path.join(dir_path, f"{base}_community_labels.json")
        csv_path = os.path.join(dir_path, f"{base}_evolution.csv")
        output_path_1 = os.path.join(dir_path, f"{base}_sankey_merges_and_splits.html")
        output_path_2 = os.path.join(dir_path, f"{base}_sankey_all.html")

        print(f"Generating Sankey diagrams for {base}...")
        generate_sankey_from_lifespans(
            lifespans_path,
            labels_path,
            csv_path,
            output_path_1,
            include_births_and_deaths=False
        )
        generate_sankey_from_lifespans(
            lifespans_path,
            labels_path,
            csv_path,
            output_path_2,
            include_births_and_deaths=True
        )
        print(f"Sankey diagrams for {base} generated.")

if __name__ == "__main__":
    main()
