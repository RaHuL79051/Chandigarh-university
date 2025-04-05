import heapq
import networkx as nx
import matplotlib.pyplot as plt

def heuristic(a, b):
    return 1

# Best-First Search Algorithm
def best_first_search(graph, start, goal):
    frontier = []
    heapq.heappush(frontier, (heuristic(start, goal), start))
    came_from = {}
    came_from[start] = None
    
    while frontier:
        _, current = heapq.heappop(frontier)
        
        if current == goal:
            break
        
        for next_node in graph[current]:
            if next_node not in came_from:
                priority = heuristic(next_node, goal)
                heapq.heappush(frontier, (priority, next_node))
                came_from[next_node] = current
    
    path = []
    current = goal
    while current != start:
        path.append(current)
        current = came_from[current]
    path.append(start)
    path.reverse()
    
    return path

if __name__ == "__main__":
    graph = {
        'A': ['B', 'C'],
        'B': ['D', 'E'],
        'C': ['F'],
        'D': [],
        'E': ['G'],
        'F': ['G'],
        'G': []
    }
    
    start = 'A'
    goal = 'G'
    
    path = best_first_search(graph, start, goal)
    print("Path found:", path)
    
    # Generate the graph using networkx
    G = nx.DiGraph(graph)
    pos = nx.spring_layout(G)
    
    plt.figure(figsize=(6, 4))
    nx.draw(G, pos, with_labels=True, node_color='lightblue', edge_color='gray', node_size=2000, font_size=12)
    path_edges = [(path[i], path[i+1]) for i in range(len(path)-1)]
    plt.title("Best-First Search Path")
    plt.show()