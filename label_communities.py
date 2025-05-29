import json
import networkx as nx
from networkx import Graph
from collections import Counter
import ast

def label_communities(graph_filepath, communities_filepath, top_n=1):
    """
    Assign top keywords as labels to each community based on node attributes.

    Parameters:
        graph_filepath: Path to the GEXF graph file
        communities_filepath: Path to JSON file with community lifespans
        top_n: Number of top keywords to include in labels

    Returns:
        Dictionary mapping community ID to its label and size
    """
    with open(communities_filepath, 'r') as f:
        communities = json.load(f)

    graph = nx.read_gexf(graph_filepath)

    node_attributes = graph.nodes(data=True)
    for node, attributes in node_attributes:
        if 'keywords' in attributes:
            mode = 'nodes'
        else:
            mode = 'edges'
        break

    community_labels = {}

    for community, values in communities.items():
        start_time = values['start_time']
        end_time = values.get('end_time', None)
        start_time = int(start_time[:4])
        end_time = int(end_time[-4:]) if end_time else 2025

        members = list(values['member_window_counts'].keys())
        counter = Counter()

        for member in members:
            if mode == 'nodes':
                if member not in graph:
                    continue
                node = graph.nodes[member]
                keywords = node.get('keywords', '')

                if keywords and keywords[0] == '{':
                    try:
                        keywords = ast.literal_eval(keywords)
                        for year, keyword_list in keywords.items():
                            year = int(year)
                            if start_time <= year <= end_time:
                                for keyword in keyword_list:
                                    counter[keyword] += 1
                    except Exception:
                        continue
                else:
                    for keyword in keywords.split('; '):
                        counter[keyword] += 1

        top_keywords = [kw for kw, _ in counter.most_common(top_n)]
        community_labels[community] = {
            "labels": top_keywords,
            "size": len(members)
        }

    return community_labels

def main():
    """
    Generate community labels for multiple GEXF graphs and save results as JSON.
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
        graph_filepath = f'{base}.gexf'
        communities_filepath = f'communities/community_evolution/{base}/{base}_community_lifespans.json'
        print(f"Labeling communities for {base}...")
        community_labels = label_communities(graph_filepath, communities_filepath, top_n=3)

        output_filepath = f'communities/community_evolution/{base}/{base}_community_labels.json'
        with open(output_filepath, 'w') as f:
            json.dump(community_labels, f, indent=4)
        print(f"Community labels saved to {output_filepath}")

if __name__ == "__main__":
    main()
