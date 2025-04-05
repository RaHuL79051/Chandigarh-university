import heapq
import networkx as nx
import matplotlib.pyplot as plt
def a_star_search(graph, start, goal, heuristic):
    priority_queue = []
    heapq.heappush(priority_queue, (0 + heuristic[start], start, [start]))
    visited = set()
    g_scores = {start: 0}
    while priority_queue:
        f_score, current_node, path = heapq.heappop(priority_queue)
        if current_node in visited:
            continue
        visited.add(current_node)
        if current_node == goal:
            return path
        for neighbor in graph.neighbors(current_node):
            edge_cost = graph[current_node][neighbor]['weight']
            tentative_g_score = g_scores[current_node] + edge_cost
            if neighbor not in visited or tentative_g_score < g_scores.get(neighbor, float('inf')):
                g_scores[neighbor] = tentative_g_score
                f_score = tentative_g_score + heuristic[neighbor]
                heapq.heappush(priority_queue, (f_score, neighbor, path + [neighbor]))
    return None
G = nx.Graph()
edges = [
    ('A', 'B', 2), ('A', 'C', 5), ('B', 'D', 3), ('B', 'E', 4),
    ('C', 'F', 6), ('C', 'G', 7), ('D', 'H', 5), ('E', 'H', 2),
    ('F', 'H', 3), ('G', 'H', 4)
]
G.add_weighted_edges_from(edges)
heuristic = {
    'A': 7, 'B': 5, 'C': 6, 'D': 3,
    'E': 4, 'F': 2, 'G': 1, 'H': 0
}
start_node = 'A'
goal_node = 'F'
result_path = a_star_search(G, start_node, goal_node, heuristic)

print("A* Search Path:", result_path)
plt.figure(figsize=(8, 6))
pos = nx.spring_layout(G)
nx.draw(G, pos, with_labels=True, node_size=2000, node_color='lightblue', edge_color='gray', font_size=12, font_weight='bold')
edge_labels = {(u, v): d['weight'] for u, v, d in G.edges(data=True)}
nx.draw_networkx_edge_labels(G, pos, edge_labels=edge_labels)
plt.title("Graph Representation of A* Search")
plt.show()
