# **Summary**

**geocoding.py:** Geocodes author institutions via Google Maps API. Stores structured metadata in geocode\_cache.json and enriches the Library with the geographic information.

**semantic.py:** Extracts TF-IDF noun phrase keywords, stores them per article and author, and outputs mto\_library\_with\_keywords.json.

**mto.py:** Builds six graphs from the enriched library: citations, semantic proximity, co-occurrence, author interactions, and article-keyword links.

**stats.py:** Cleans each graph and computes degree distributions, clustering, and connected components. Outputs saved in graph\_stats/.

**centrality\_analysis.py:** Slices graphs into temporal snapshots, computes centrality metrics, and saves results in centrality\_snapshots/.

**node2vec\_analysis.py:** Runs Node2Vec on author interaction graphs over time. Outputs embeddings and trajectory plots to node2vec\_embeddings/ and node2vec\_plots/.

**track\_drift.py:** Computes author drift across time from Node2Vec embeddings. Saves results in author\_drift\_summary.csv.

**semantic\_drift.py:** Tracks keyword co-occurrence shifts over time via cosine drift. Outputs include keyword\_drift\_scores.csv and plots in semantic\_drift\_plots/.

**community\_detection.py:** Runs Infomap on graph snapshots to assign communities. Saves node-level assignments and stats in communities/.

**community\_evolution.py:** Tracks community changes (births, splits, merges, etc.) via Jaccard similarity. Outputs event logs and lifespan metadata.

**label\_communities.py:** Assigns each community its top keywords based on member metadata. Saves \*\_community\_labels.json.

**sankey\_plots.py:** Builds Sankey diagrams visualizing community evolution using merges, splits, and optional births/deaths.

# **geocoding.py**

This script geocodes author addresses from a Library object using the Google Maps API and stores structured location metadata. It supports caching geocoding results to avoid redundant queries, applies geocoded data to the library’s author records, and provides a utility to re-save cache files using UTF-8 encoding for compatibility. The geocoded fields are saved per author and optionally written back into the Library.

## Functions

### build\_geocode\_cache\_from\_library

**Purpose:** Queries the Google Maps API to geocode author addresses or universities and caches the results.  
**Inputs:**

* library: Library object containing author data  
* api\_key: Google Maps API key  
* cache\_file: Path to save the geocode cache (default: "geocode\_cache.json")  
* delay: Number of seconds to wait between queries (default: 1\)

**Details:**

* Each author's address field is used if present; otherwise, the university is used  
* Results include structured address components and coordinates  
* If an entry already exists in the cache, it is skipped  
* Failed lookups still create an empty fallback entry  
* Does not modify the Library in memory  
* The cache is saved to disk after all lookups

### apply\_geocode\_cache\_to\_library

**Purpose:** Applies a cached geocode file to populate geospatial metadata in each author’s record.  
**Inputs:**

* library: Library object whose authors should be updated  
* cache\_file: Path to the geocode cache file (default: "geocode\_cache.json")

**Details:**

* Adds the following fields to author.data:  
  * geo\_house\_number, geo\_road, geo\_city, geo\_county, geo\_state, geo\_country, geo\_postcode, geo\_university, lat, lng  
  * Uses address if present, otherwise uses university name to query the cache  
  * Does nothing if no match is found in the cache

## Output Files

### geocode\_cache.json

**Description:** A JSON cache of geocoded author locations, keyed by query string (address or university).  
**Format:** Dictionary where each key is a location string and each value is a dictionary with:

* house\_number  
* road  
* city  
* county  
* state  
* country  
* postcode  
* university  
* lat  
* lng

**Notes:**

* Used as both input and output by the geocoding and application functions  
* This file grows over time and prevents redundant API calls

### Modified Library file (e.g. mto\_library.json)

**Description:** If apply\_geocode\_cache\_to\_library() is called, the Library object is updated with geospatial fields per author and can be saved afterward.  
**Format:** The author.data fields will now include all geo\_\* fields and coordinates.

# **semantic.py**

This script processes MTO article JSONs to extract top keywords using TF-IDF, filters them using syntactic analysis (noun phrases), caches and stores the results, and enriches a Library object with both per-publication and per-author keyword metadata. 

## Functions

### load\_article\_texts

**Purpose:** Loads article files and constructs a unified text field from the title, abstract, and body.  
**Inputs:**

* data\_dir: Directory containing article .json files

**Outputs:**

* A list of dictionaries, each with:  
  * filename: name of the source file  
  * text: concatenated string from title, abstract, and body  
  * title: article title  
  * authors: list of authors  
  * year: publication year as an integer (or None if unavailable)

**Details:**

* Handles malformed or missing "paragraphs" by falling back to "body" or "content" fields  
* Body text is flattened from nested structures if necessary  
* Year is extracted from the first four digits of a "date" string, if available

### extract\_keywords\_tfidf

**Purpose:** Extracts top-N keywords per article using TF-IDF, then filters to noun phrases using spaCy.  
**Inputs:**

* articles: Output from load\_article\_texts  
* top\_n: Final number of keywords to retain per article  
* output\_path: Destination file for final keyword records  
* cache\_path: Path to cache file for incremental processing

**Outputs:**

* Writes output\_path as a list of dictionaries, each with:  
* filename, title, authors, year, and keywords

**Details:**

* TF-IDF vectorizer supports 1- to 3-grams  
* For each article:  
  * Selects top\_n highest-TF-IDF phrases  
  * Filters to phrases that appear as noun chunks in spaCy parsing  
  * Removes phrases \< 2 characters and strips trailing punctuation  
  * Caches results incrementally every 10 processed articles  
  * If all articles are already in the cache, skips recomputation and writes cached output directly

### count\_global\_keywords

**Purpose:** Counts keyword frequencies across all articles  
**Inputs:**

* keywords\_path: File with per-article keyword lists  
* output\_path: File to write global frequency counts  
* print\_top\_n: Number of top keywords to display  
* save\_txt: If True, saves top keywords as plaintext  
* txt\_path: Path for optional plaintext file

**Outputs:**

* Writes output\_path as a JSON list of (keyword, count) pairs  
* Optionally writes txt\_path as newline-separated top keywords

**Details:**

* Deduplicates keywords within each article before counting  
* Prints top keywords and total unique keywords to terminal

### enrich\_library\_with\_keywords\_from\_file

**Purpose:** Attaches keyword metadata to Library structure on the publication and author levels.  
**Inputs:**

* library\_path: Path to the base Library (e.g. mto\_library.json)  
* keywords\_path: File with extracted keyword records  
* output\_path: File to write the enriched Library  
* stopword\_file: File listing stopwords to exclude from author vocabularies

**Outputs:**

* Writes output\_path as an enriched Library structure, where:  
  * Each publication has a keywords field  
  * Each author has a {year: \[keywords\]} mapping under data\["keywords"\]

**Details:**

* Matches keyword records to publications by title  
* Publications with no match are given an empty list of keywords and reported  
* Author vocabularies are computed per year, excluding stopwords and sorted alphabetically

## Output Files

### mto\_keywords\_cache.json

**Description:** Cache of per-article keyword extraction results, used to avoid recomputation.  
**Format:** JSON list of dictionaries. Each dictionary includes:

* filename  
* title  
* authors  
* year  
* keywords

**Notes:** This file is updated every 10 articles during extraction and again at the end.

### mto\_keywords.json

**Description:** Final output of TF-IDF keyword extraction for all articles.  
**Format:** JSON list of dictionaries, same structure as the cache file.  
**Notes:** Written at the end of the keyword extraction process, or immediately if all results are already cached.

### keyword\_global\_counts.json

**Description:** Global frequency count of all keywords across the corpus.  
**Format:** JSON list of (keyword, count) pairs, sorted by frequency in descending order.  
**Notes:** Keywords are deduplicated within each article before counting.

### top\_keywords.txt (optional)

**Description:** Plain text file listing the top N most frequent keywords, one per line.  
**Format:** Plain text  
**Notes:** Only written if save\_txt is True when calling count\_global\_keywords.

### mto/mto\_library\_with\_keywords.json

**Description:** Updated Library object with keyword metadata added to publications and authors.  
**Format:** JSON, as output by Library.save().  
**Notes:**

* Each publication includes a keywords list  
* Each author has a keywords dictionary mapping year to list of keywords  
* Keywords listed for authors exclude any from stopwords.txt

# **Additions to mto.py**

These additions to the script construct various graphs representing relationships among scholarly articles and authors using a Library object. Graphs include citation networks, author collaborations, co-authorship and citation interactions, keyword-based article linking, temporal and semantic proximity, and edge-collapsed summaries. All graphs are exported as GEXF files.

## Functions

### generate\_citation\_network

**Purpose:** Generates a graph of publications with edges for direct citations and shared references.  
**Inputs:**

* library: Library object with publications and references  
* output\_path: File path to save the GEXF graph (default: "mto\_citations.gexf")

**Details:**

* Nodes include metadata: title, year, authors, category, keywords  
* Adds direct edges A → B if A cites B  
* Adds undirected edges between pairs of articles that cite the same third article  
* Shared-reference edges do not overwrite direct citation edges  
* Edge attributes: type, year, years\_since\_1993

### generate\_author\_relationships

**Purpose:** Computes pairwise collaboration and citation counts between authors.  
**Inputs:**

* library: Library object  
* output\_path: Path to save the JSON file (default: "mto\_author\_relationships.json")

**Details:**

* Collaborations are unordered pairs from co-authored publications  
* Citations are directed pairs from citing author to cited author  
* Multiple collaborations and citations are counted  
* Output JSON contains two dictionaries: collaborations and citations

### generate\_author\_interaction\_graph

**Purpose:** Generates a directed multigraph with two edge types: collaboration and citation.  
**Inputs:**

* library: Library object  
* output\_path: Path to save GEXF graph (default: "mto\_author\_interactions.gexf")

**Details:**

* Nodes include attributes: name, university, city, state, country, lat/lng (latitude/longitude), first\_year, keywords  
* Collaboration edges are bidirectional between all co-authors of a paper  
* Citation edges are directional from citing author to cited author  
* Edge attributes include: relation, year, years\_since\_1993

### generate\_keyword\_linked\_article\_graph

**Purpose:** Creates an undirected graph of articles connected by shared keywords.  
**Inputs:**

* library: Library object  
* output\_path: GEXF output path (default: "mto\_article\_keyword\_links.gexf")  
* keyword\_count\_file: Path to keyword\_global\_counts.json  
* min\_keyword\_count: Threshold for including a keyword in edge generation

**Details:**

* Edges are added between articles that share one or more valid keywords  
* Valid keywords are filtered by global count  
* Edge attributes: keywords, weight  
* Node attributes include metadata: title, year, authors, category, keywords

### generate\_semantic\_reachability\_graph

**Purpose:** Builds a directed graph where edge A → B exists if B is reachable from A via citations and shares at least one keyword.  
**Inputs:**

* library: Library object  
* max\_depth: Maximum number of citation hops allowed (default: 2\)  
* output\_path: GEXF output path (default: "mto\_semantic\_reachability.gexf")

**Details:**

* Traverses citation graph using BFS  
* Edge is added only if reachable paper shares at least one keyword  
* Edge attributes: keywords, weight, depth  
* Node attributes: standard publication metadata  
* Tracks edge counts by citation depth

### generate\_temporal\_keyword\_graph

**Purpose:** Generates undirected edges between articles that share keywords and are published within a certain year range.  
**Inputs:**

* library: Library object  
* year\_range: Maximum allowed difference in publication years (default: 1\)  
* output\_path: GEXF output path (default: "mto\_temporal\_keyword\_graph.gexf")

**Details:**

* Compares all article pairs for year proximity and keyword overlap  
* Edge attributes: keywords, weight, year\_diff  
* Node attributes: title, year, authors, category, keywords

### collapse\_multiedges\_by\_relation\_and\_year

**Purpose:** Collapses MultiDiGraph edges into one per (source, target, relation, year) pair.  
**Inputs:**

* input\_file: Path to input GEXF (must be MultiDiGraph)  
* output\_file: Optional output path (defaults to \*\_collapsed.gexf)

**Details:**

* Aggregates multiple edges between the same pair of nodes with same relation and year  
* Edge attributes: relation, year, years\_since\_1993, count

## Output Files

### mto\_citations.gexf

**Description:** Graph of publication-level citations and shared references.  
**Node attributes:** title, year, authors, category, keywords  
**Edge attributes:** type, year, years\_since\_1993

### mto\_collaborations.gexf

**Description:** Author co-authorship network.  
**Node:** author ID  
**Edge:** present if authors co-wrote at least one paper

### mto\_author\_relationships.json

**Description:** Author collaboration and citation frequency data.  
**Format:** JSON with two dictionaries:  
**"collaborations":** unordered author pairs → count  
**"citations":** ordered author pairs → count

### mto\_author\_interactions.gexf

**Description:** Directed multigraph of authors with citation and collaboration edges.  
**Node attributes:** name, affiliation, location, keywords  
**Edge attributes:** relation, year, years\_since\_1993

### mto\_author\_interactions\_collapsed.gexf

**Description:** Collapsed version of the above, one edge per (author1, author2, relation, year).  
**Edge attributes:** relation, year, years\_since\_1993, count

### mto\_article\_keyword\_links.gexf

**Description:** Article graph where edges represent shared keywords above a frequency threshold.  
**Node attributes:** title, year, authors, category, keywords  
**Edge attributes:** keywords, weight

### mto\_semantic\_reachability.gexf

**Description:** Directed citation-based semantic graph (A → B if B is reachable and shares keywords).  
**Edge attributes:** keywords, weight, depth

### mto\_temporal\_keyword\_graph.gexf

**Description:** Graph connecting articles published within a close time window and sharing keywords.  
**Edge attributes:** keywords, weight, year\_diff

# **stats.py**

This script performs structural analysis, centrality computation, and temporal slicing on scholarly networks represented as GEXF graphs. It includes tools to clean and analyze graph variants, generate plots, compute centrality metrics (degree, betweenness, eigenvector), and output temporal snapshots of networks over time. It supports both undirected and directed graphs and handles node/edge-level temporal metadata.

## Functions

### graph\_stats

**Purpose:** Compute structural statistics for a graph.  
**Inputs:**

* G: NetworkX graph

**Outputs:**

* Dictionary with:  
  * num\_nodes  
  * num\_edges  
  * average\_degree  
  * isolated\_nodes  
  * self\_loops  
  * degree\_distribution  
  * in/out degree distribution (if directed)  
  * diameter and avg\_shortest\_path\_length (if connected)  
  * avg\_clustering\_coefficient

### analyze\_graph\_versions

**Purpose:** Analyze 3 cleaned versions of a graph and save stats.  
**Inputs:**

* G: NetworkX graph  
* label: Output filename prefix  
* outdir: Output directory

**Outputs:**

* JSON file of stats for:  
  * no\_self\_loops  
  * no\_self\_loops\_no\_isolates  
  * no\_self\_loops\_largest\_component

### plot\_degree\_distributions

**Purpose:** Generate and save degree histograms.  
**Inputs:**

* stats\_file: JSON file from analyze\_graph\_versions  
* output\_dir: Folder to write PNGs

**Outputs:**

* PNG plots of degree, in-degree, out-degree (if applicable)

### compute\_centrality\_metrics

**Purpose:** Compute and export centrality metrics to CSV.  
**Inputs:**

* gexf\_file: Path to input graph (optional if graph is passed)  
* output\_csv: Path to save CSV (optional)  
* graph: In-memory NetworkX graph (optional)

**Outputs:**

* CSV with columns:  
  * node  
  * degree\_centrality  
  * betweenness\_centrality  
  * eigenvector\_centrality

### compute\_filtered\_and\_save

**Purpose:** Filter a GEXF graph by relation and compute centrality.  
**Inputs:**

* graph\_path: Path to GEXF file  
* relation\_filter: Optional relation type (e.g. "citation")  
* output\_tag: Optional suffix for output

**Outputs:**

* CSV with centrality metrics on filtered graph

### generate\_temporal\_snapshots

**Purpose:** Create snapshots of a graph across time windows.  
**Inputs:**

* graph: NetworkX graph  
* mode: "edges" or "nodes"  
* snapshot\_size: Window width in years  
* rolling: Whether to include past years  
* output\_dir: Where to save files  
* remove\_isolates: Remove isolated nodes in each window  
* largest\_component\_only: Keep only largest component  
* save: Whether to write to GEXF

**Outputs:**

* List of (start\_year, end\_year, snapshot\_graph)  
* Optional GEXF files saved to disk

## Output Files

### graph\_stats/{label}\_stats.json

Contains statistics for three graph variants:

* no\_self\_loops  
* no\_self\_loops\_no\_isolates  
* no\_self\_loops\_largest\_component

### graph\_stats/plots/{label}\_{variant}\_degree\_distribution.png

* Histogram of degree distribution for each variant  
* Also includes in/out-degree if applicable

### {graph\_name}\_centrality.csv

* Centrality metrics (degree, betweenness, eigenvector)  
* Variants include:  
  * \_all  
  * \_collaboration  
  * \_citation

### snapshots/edges\_snapshot\_{start}\_{end}.gexf

* Edge-based temporal subgraph between start and end year  
* Includes all edges in that window (or cumulatively if rolling=True)

# **centrality\_analysis.py**

This script computes centrality metrics over time for various scholarly graphs by slicing them into temporal snapshots. It tracks degree, betweenness, and eigenvector centrality over time, and generates line plots for top entities by each metric.

## Functions

### compute\_centrality\_metrics

**Purpose:** Compute degree, betweenness, and eigenvector centrality for a single graph.  
**Inputs:**

* gexf\_file: optional path to GEXF file  
* output\_csv: optional path to save CSV  
* graph: NetworkX graph (preferred if available)

**Outputs:**  
CSV with per-node centrality metrics  
**Details:**

* Uses largest connected component for eigenvector centrality  
* Converts MultiGraphs to simple Graphs for stability

### run\_centrality\_over\_time

**Purpose:** Compute centrality metrics across time windows using graph snapshots.  
**Inputs:**

* graph\_path: GEXF file path  
* snapshot\_mode: "edges" or "nodes"  
* snapshot\_size: window width (e.g. 3 years)  
* rolling: whether each window includes all earlier data  
* remove\_isolates: remove isolates per snapshot  
* largest\_component\_only: retain only largest component per snapshot  
* output\_dir: directory to save CSVs

**Outputs:**

* combined\_df: full DataFrame with all snapshots  
* snapshot\_dir: output path used  
* G: original graph

**Details:**

* Calls generate\_temporal\_snapshots from stats  
* Writes a separate CSV for each interval  
* Also saves centrality\_over\_time.csv with all results

### plot\_centrality\_trends

**Purpose:** Plot temporal trend lines for the top-n nodes by a given centrality metric.  
**Inputs:**

* df: centrality data over time  
* metric: one of "degree\_centrality", "betweenness\_centrality", "eigenvector\_centrality"  
* output\_dir: where to save plots  
* graph: original graph (for node metadata)  
* top\_n: number of nodes to show in plot

**Outputs:**

* PNG plot of time series

**Details:**

* Uses pivot to reshape DataFrame for time series  
* Automatically labels nodes using title, label, or author \+ title

## Output Files

### centrality\_snapshots/{graph\_name}/centrality\_{start}\_{end}.csv

Per-window CSV with centrality metrics for each node

### centrality\_snapshots/{graph\_name}/centrality\_over\_time.csv

Combined CSV with centrality metrics for all windows

### centrality\_snapshots/{graph\_name}/{metric}\_trend.png

Plot showing centrality trend over time for top-n nodes in the graph

# **node2vec\_analysis.py**

This script trains Node2Vec embeddings on temporal snapshots of a graph, visualizes the 2D PCA-projected embeddings, and saves both the coordinates and the plots. It is primarily used to analyze how author interactions evolve over time.

## Functions

### run\_node2vec\_embedding

**Purpose:** Runs Node2Vec on a graph and reduces dimensions with PCA if needed.  
**Inputs:**

* G: NetworkX graph  
* dimensions: dimensions for initial embedding (default 64\)  
* walk\_length: random walk length  
* num\_walks: number of walks per node  
* p, q: Node2Vec hyperparameters  
* workers: parallel workers  
* seed: random seed  
* reduce\_dim: target dimension (default 2\)

**Output:**

* DataFrame with node embeddings (columns: x0, x1, ...) indexed by node ID

**Details:**

* Runs Node2Vec random walks and trains a skip-gram model internally  
* Applies PCA to reduce dimensionality for plotting (if reduce\_dim \< dimensions)

### visualize\_embedding

**Purpose:** Plots a 2D scatterplot of embeddings colored by snapshot.  
**Inputs:**

* df: DataFrame with at least columns x0, x1, and snapshot  
* title: plot title  
* output\_file: optional path to save image

**Output:**

* Saves PNG if path is provided; otherwise shows interactively

**Details:**

* Uses seaborn.scatterplot for color-coded visualization  
* Automatically truncates long labels using up to 6 words  
* Optimized for author or paper embeddings across time

### run\_node2vec\_on\_snapshots

**Purpose:** Main routine to compute Node2Vec embeddings for temporal graph slices.  
**Inputs:**

* graph\_path: path to GEXF file  
* snapshot\_size: window size in years  
* output\_dir: folder for CSV embeddings  
* plot\_dir: folder for output plots

**Output:**

* CSV and PNG files per snapshot  
* Combined snapshot visualization  
* Embedding on full graph

**Details:**

* Uses rolling snapshots via generate\_temporal\_snapshots() with mode="edges"  
* Skips snapshots with fewer than 10 nodes  
* Applies run\_node2vec\_embedding to each snapshot and the full graph  
* Uses PCA to reduce to 2D for visualization  
* Appends "snapshot" and "author\_id" columns to each output

## Output Files

Output files are created in the node2vec\_embeddings and node2vec\_plots directories.

### node2vec\_{start}\_{end}.csv

* One per snapshot (e.g., node2vec\_1993\_1996.csv)  
* Contains 2D PCA-reduced embeddings (x0, x1)  
* Includes author\_id and snapshot columns

### node2vec\_{start}\_{end}.png

* Scatterplot of embeddings for each snapshot  
* Colored by snapshot label  
* Saved to node2vec\_plots/

### node2vec\_full.csv

* Embeddings for the full (non-snapshot) graph  
* Same format as snapshot CSVs  
* Snapshot column is "full"

### node2vec\_full.png

* Visualization of full graph embeddings  
* 2D scatterplot using PCA-reduced coordinates  
* node2vec\_all\_snapshots.png  
* Combined plot of all snapshots \+ full graph  
* Nodes colored by snapshot window

# **track\_drift.py**

This script loads per-snapshot author embeddings, computes Euclidean drift for each author across time, and visualizes the trajectory for the most dynamic author.

### load\_all\_embeddings

**Purpose:** Load all Node2Vec embedding CSV files for temporal snapshots (excluding full graph).  
**Input:**

* folder: Directory containing files like node2vec\_YYYY\_YYYY.csv

**Output:**

* Combined DataFrame of all snapshot embeddings

**Details:**

* Skips node2vec\_full.csv  
* Each file must include: x0, x1, snapshot, and author\_id columns

### compute\_author\_drift

**Purpose:** Measure how far each author moves in 2D embedding space over time.  
**Input:**

* A DataFrame of node embeddings per snapshot (must include x0, x1, author\_id, and snapshot)

**Output:**

* A DataFrame summarizing:  
  * Total drift distance  
  * Number of snapshots  
  * Segment-wise drift per interval

**Details:**

* Uses Euclidean distance between each consecutive snapshot  
* Aggregates per-author across time

### plot\_author\_trajectory

**Purpose:** Plot the embedding-space trajectory of one author over time.  
**Input:**

* df: Embeddings from multiple snapshots  
* author\_id: ID of author to plot

**Output:**

* On-screen matplotlib plot

Details:

* Annotates each point with snapshot label  
* Draws a connected line through positions

## Output Files

### author\_drift\_summary.csv

* CSV summarizing drift for each author  
* Columns: author\_id, drift\_total, snapshot\_count, drift\_path  
* Purpose: used for ranking authors by discourse movement

### (Optional/visual) Trajectory Plot

* Not saved to file by default; shown using plt.show()  
* Plots 2D positions over time for the author with highest drift  
* Purpose: provides a qualitative look at trajectory shape

# **semantic\_drift.py**

This script tracks and visualizes how keyword meanings shift over time by modeling co-occurrence patterns in sliding time windows. It computes semantic drift scores, dimensionality-reduced trajectories, and keyword similarity over time.

## Functions

### get\_time\_window

**Purpose:** Generate a list of time window labels  
**Input:** 

* start: Earliest year (default 1993\)  
* end: Latest year (default 2025\)  
* window: Size of each time window (default 5\)

**Output:** 

* List of tuples like \[(1993, 1997), (1998, 2002), ...\]

**Details:**

* Controlled by MIN\_YEAR, MAX\_YEAR, and WINDOW\_SIZE

### assign\_window

**Purpose:** Assign a given year to its labeled window like "1998-2002"  
**Input:** 

* year: Publication year  
* window\_size: Width of time window

**Output:** 

* String window label

### build\_keyword\_window\_cooccurrence

**Purpose:** Build co-occurrence counts of keywords per time window  
**Input:** 

* keywords\_data: List of article keyword dicts  
* stopwords: Set of stopwords to exclude

**Output:**

* cooccur: dict\[kw\]\[window\]\[other\_kw\] → count  
* vocab: total counts of each keyword

**Details:**

* Filters stopwords  
* Deduplicates keywords within an article

### cooccurrence\_vectors

**Purpose:** Generate normalized co-occurrence vectors per keyword per window  
**Input:**

* cooccur: Output from previous function  
* vocab: Keyword frequency Counter  
* min\_count: Minimum frequency for inclusion

**Output:**

* drift\_vectors: dict\[keyword\]\[window\] → normalized vector  
* vocab\_list: filtered keyword list (min count threshold)

**Details:**

* Only keywords with ≥ MIN\_GLOBAL\_COUNT are included  
* Uses L2 normalization

### compute\_drift\_scores

**Purpose:** Compute total cosine distance drift across time windows  
**Input:** 

* drift\_vectors: Output from cooccurrence\_vectors

**Output:** 

* DataFrame with columns: keyword, drift\_total, distances

**Details:**

* Sorted by drift\_total descending  
* Each distances is a list of (window\_a, window\_b, cosine\_distance)

### compute\_pca\_trajectories

**Purpose:** Reduce all keyword vectors to 2D using PCA for plotting  
**Input:**

* drift\_vectors: Keyword → window → vector

**Output:** 

* DataFrame with x, y, keyword, window

**Details:**

* Flattens all vectors into one matrix before PCA

### plot\_keyword\_drift

**Purpose:** Plot drift magnitude across time for one keyword  
**Input:** 

* keyword: Target keyword  
* distances: List of (start, end, distance) tuples  
* output\_dir: Folder to write plots

**Output:** 

* Saves PNG line plot to semantic\_drift\_plots/

### plot\_pca\_trajectories

**Purpose:** Plot semantic trajectories for selected keywords in PCA space  
**Input:**

* df: DataFrame from compute\_pca\_trajectories  
* target\_keywords: List of keywords to include  
* output\_dir: Plot output folder  
* show\_labels: Whether to show window labels  
* filename: Output filename

**Output:** 

* Saves PNG scatterplot with labeled or unlabeled curves

**Details:**

* One trajectory per keyword  
* Labels first and last time points optionally

**plot\_similar\_trajectories**  
**Purpose:** Plot similar trajectories to a reference keyword  
**Input:**

* drift\_vectors: Cooccurrence vectors  
* reference\_keyword: Target keyword  
* method: Distance metric (average or max)  
* top\_n: Number of similar terms to show  
* min\_windows: Minimum shared windows required  
* output\_dir: Folder to save results

**Output:** Saves plot of most similar 5 trajectories to reference  
**Details:**

* Similarity measured as average or max Euclidean distance across common windows

## Output Files

**keyword\_drift\_scores.csv**

* Contains total drift values per keyword  
* Includes list of cosine distances across time windows

**semantic\_drift\_plots/ (folder)**

* {keyword}\_drift.png: line plots of cosine distance over time for top keywords  
* semantic\_trajectories\_pca.png: 2D PCA plot for 50 most common terms  
* similar\_to\_{keyword}.png: PCA plots showing terms most similar in trajectory to selected keyword

# **community\_detection.py**

This script tracks community structure over time in a dynamic graph using the Infomap algorithm. It slices the input graph into temporal snapshots, applies Infomap to each, assigns nodes to communities, and outputs a timeline of community memberships and statistics. It also visualizes changes in the number and size of communities over time.

## Functions

### track\_communities\_over\_time

**Purpose:** Track community assignments for each node over time using temporal snapshots and Infomap.  
**Input:**

* gexf\_filename: Path to the input GEXF file  
* window\_size: Length (in years) of each temporal snapshot  
* rolling: Whether snapshots are accumulated over time  
* output\_filename: Optional CSV name for output (auto-generated if None)  
* mode: Whether to slice time by 'edges' or 'nodes'  
* remove\_isolates: Whether to drop isolates in each snapshot  
* largest\_component\_only: Whether to restrict to largest component per snapshot

**Output:**

* Pandas DataFrame: node → community label for each snapshot

**Details:**

* Uses Infomap to detect communities in each snapshot  
* Assigns community IDs per node per window  
* Computes and plots number, mean size, and max size of communities  
* Saves node-community CSV and summary statistics

## Output Files

### communities/node\_communities/{graph}\_communities.csv

* Matrix of node community memberships by time window  
* Rows \= node IDs, columns \= time windows

### communities/community\_stats/{graph}\_community\_stats.csv

* Summary stats for each snapshot:  
  * Number of communities  
  * Mean community size  
  * Max community size

### communities/community\_plots/{graph}\_community\_stats.png

* Line plot over time showing:  
  * Number of communities  
  * Mean and max community sizes  
* One line per metric

# **community\_evolution.py**

This script analyzes the temporal evolution of communities across network snapshots. It compares community memberships between time windows using Jaccard similarity, classifies transitions (e.g., splits, merges, survivals), and tracks the lifespan and membership stability of each community. The output includes labeled events, metadata for each community, and a visualization of event types over time.

## Functions

### track\_community\_evolution

**Purpose:** Identify and categorize events (e.g., splits, merges, survivals, deaths, births) in community evolution across network snapshots.  
**Input:**

* filepath: Path to the node-community CSV file  
* thresholds: Dictionary with thresholds for survive, split, and merge events  
* priority: Ordered tuple of event types to resolve overlaps  
* include\_single\_window\_communities: Whether to include communities active in only one window  
* label\_strategy: How to select representative authors for community labeling ("random", "alphabetical", "most\_present")  
* top\_k: Number of top authors to use for labeling

**Output:**

* Pandas DataFrame: all community transition events over time

**Details:**

* Uses Jaccard similarity to compare communities between snapshots  
* Assigns community lifespans and member continuity counts  
* Labels each community using the selected label strategy  
* Skips or includes one-window communities based on flag  
* Saves structured metadata and event breakdowns

## Output Files

Files are placed in the directory communities/community\_evolution/.

### {graph}/mto\_author\_interactions\_evolution.csv

* Table of all community transition events  
* Columns: time, type (event), source community, target community, score(s)

### {graph}/mto\_author\_interactions\_event\_counts.json

* JSON of event type counts by year  
* Used for stacked bar visualization

### {graph}/mto\_author\_interactions\_community\_lifespans.json

* Metadata for each community’s full lifespan  
* Includes:  
  * start\_time / end\_time  
  * start\_type / end\_type  
  * member\_window\_counts: author persistence  
  * label\_authors: representative member IDs

### communities/community\_evolution/{graph}/mto\_author\_interactions\_event\_plot.png

* Stacked bar chart of event type counts over time  
* X-axis: year, Y-axis: number of events per type

# **label\_communities.py**

This script assigns keyword-based labels to communities across time by analyzing node attributes in a GEXF graph and aligning them with community membership over time (from lifespans). It supports both node-based and edge-based keyword storage, processes multiple graphs, and writes out JSON label files per graph.

## Functions

### label\_communities

**Purpose:** Assign top keyword labels to each community using node-level metadata across its active time window.  
**Input:**

* graph\_filepath: Path to the .gexf file containing the graph with node or edge metadata.  
* communities\_filepath: Path to a JSON file with temporal community lifespans and member counts  
* top\_n: Number of keywords to include in each community’s label (default \= 1).

**Output:**

* A dictionary mapping each community ID to:  
* "labels": list of top keywords  
* "size": number of unique members associated with the community

**Details:**

* Infers mode ('nodes' vs 'edges') based on the presence of keywords in node attributes.  
* Extracts temporal ranges from start\_time and end\_time.  
* Aggregates keywords per community member over the window of activity.  
* Uses Counter to identify the most frequent keywords.

### Output Files

The above function is called on each graph.

### communities/community\_evolution/{graph}/{graph}\_community\_labels.json

* Contains:  
  * Dictionary mapping each community ID to:  
  * "labels": top 3 keywords used by its members  
  * "size": number of distinct members across time  
* Details:  
  * Community ID format: e.g., "1998\_2003\_C3"  
  * Useful for labeling plots, summaries, and analysis of evolving discourse groups

# **sankey\_plots.py**

This script generates interactive Sankey diagrams that visualize how scholarly communities evolve over time via merges, splits, births, and deaths. It uses community lifespans, keyword labels, and event data to render community transitions and their strength (Jaccard similarity). Two diagrams are produced per graph: one with merges/splits, and one with all event types.

## Functions

### generate\_sankey\_from\_lifespans

**Purpose:** Create a Sankey diagram showing the evolution of communities based on merge/split events, optionally including births and deaths.  
**Input:**

* lifespans\_path: JSON file with community lifespan metadata (e.g., start/end time, type, merge/split sources or targets).  
* labels\_path: JSON file mapping community IDs to their top keywords and sizes.  
* csv\_path: CSV file containing community evolution events with event types and scores.  
* output\_path: Path to save the resulting Sankey diagram as an HTML file.  
* include\_births\_and\_deaths: Whether to include virtual birth/death nodes in the diagram (default: False).

**Output:**

* Writes an HTML file with an interactive Sankey diagram to the specified output\_path.

**Details:**

* Converts merge and split events into weighted edges between communities.  
* Uses node sizes from the labels\_path JSON to scale thicknesses.  
* Hover text displays top keywords and Jaccard scores.  
* Optional birth/death links connect to virtual nodes for a fuller life-cycle view.

### Output Files

The above function is called for each graph. The outputs are created inside communities/community\_evolution/{graph}/.

### {graph}\_sankey\_merges\_and\_splits.html

* Visualizes only merge and split transitions.  
* No birth/death events shown.  
* Edge widths correspond to Jaccard similarity between communities.

### {graph}\_sankey\_all.html

* Includes births, deaths, merges, and splits.  
* Adds virtual start/end points to track full lifecycle of each community.  
* Useful for observing community lifespan trajectories.

# Appendix

## Stopwords

After examining the most frequent keywords outputted by TF-IDF, certain keywords were selected as stopwords and excluded from analysis if one of the following was true:

* The word is suspected to be part of the formatting/structure of the publications rather than the actual content, e.g. chapter, figure, audio example, page  
* The word is too broad to be useful as a keyword for an article, e.g. music, analysis, music theory, research, theorists  
* The word is unrelated to music or did not yield useful information about the musical content of an article, e.g. example, students, university, meaning, papers  
* The word is generally used to denote works or parts of works of music, e.g. mm, op, bar, phrase, measure


These stopwords are all listed in stopwords.txt.

## Community Evolution Event Types

**Survive**  
This means that a community continues with high structural similarity to a single community from the previous window. It is triggered when exactly one community in the next window matches with a Jaccard similarity above the “survive” threshold.

**Split**  
This means that a community breaks into two or more new communities in the next window. It is triggered when one community has a Jaccard similarity above the “split” threshold with two or more communities in the next window.

**Merge**  
This means that two or more communities from the previous window combine into one in the next. It is triggered when a community in the next window has a Jaccard similarity above the “merge” threshold with at least two communities from the previous window.

**Birth**  
This means that a community appears in a time window without any identifiable predecessor. It is triggered when no previous community has a Jaccard similarity high enough with a community in the next window to trigger a *survive* event or a *merge* event.

**Death**  
This means a community disappears in the next window without splitting or merging. It is triggered when no communities in the next window have a Jaccard similarity high enough with a community in the previous window to trigger a *survive* or *split* event. 

These decision rules are applied in the order specified by the “priority” parameter. We choose the order ("split", "merge", "survive", "death", "birth"). We use thresholds of 0.4 for survival and 0.15 for splitting and merging. 