import networkx as nx
import matplotlib.pyplot as plt

def dfs(graph, start):
  visited = set()
  stack = [start]
  while stack:
    node = stack.pop()
    if node not in visited:
      print(node, end=" ")
      visited.add(node)
      for meighbor in reversed(graph[node]):
        if meighbor not in visited:
          stack.append(meighbor)

G = nx.DiGraph()
nodes = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']
G.add_nodes_from(nodes)
edges = [
    ('H', 'A'),
    ('A', 'B'), ('A', 'D'),
    ('B', 'C'), ('B', 'F'),
    ('C', 'G'), ('C', 'E'), ('C', 'H'),
    ('E', 'F'), ('E', 'B'),
    ('D', 'F'),
    ('G', 'E'), ('G', 'H')
]

G.add_edges_from(edges)
pos = nx.spring_layout(G)
nx.draw(G, pos, with_labels=True, node_color='skyblue', edge_color='brown', node_size=2000, font_size=12, font_weight='bold')
plt.title("Directed Graph Representation")
plt.show()

if __name__ == "__main__":
  graph = {
    "A" : ["B", "D"],
    "B" : ["C", "F"],
    "C" : ["G", "E", "H"],
    "D" : ["F"],
    "E" : ["B"],
    "F" : ["A"],
    "G" : ["H", "E"],
    "H" : ["A"]
  }

start_node = 'A'
print("DFS traversal starting from node ", start_node, " : ", end="")
dfs(graph, start_node)

# ===============================================================================================================
# ===============================================================================================================
# ===============================================================================================================

# import networkx as nx
# import matplotlib.pyplot as plt
# def dfs(graph, start, visited=None):
#   if visited is None:
#     visited = set()
#   visited.add(start)
#   print(start, end=" ")
#   for neighbor in graph[start]:
#     if neighbor not in visited:
#       dfs(graph, neighbor, visited)
#   return visited

# G = nx.DiGraph()
# nodes = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']
# G.add_nodes_from(nodes)
# edges = [
#     ('H', 'A'),
#     ('A', 'B'), ('A', 'D'),
#     ('B', 'C'), ('B', 'F'),
#     ('C', 'G'), ('C', 'E'), ('C', 'H'),
#     ('E', 'F'), ('E', 'B'),
#     ('D', 'F'),
#     ('G', 'E'), ('G', 'H')
# ]
# G.add_edges_from(edges)
# pos = nx.spring_layout(G)
# nx.draw(G, pos, with_labels=True, node_color='skyblue', edge_color='brown', node_size=2000, font_size=12, font_weight='bold')
# plt.title("Directed Graph Representation")
# plt.show()

# if __name__ == "__main__":
#   graph = {
#     "A" : ["B", "D"],
#     "B" : ["C", "F"],
#     "C" : ["G", "E", "H"],
#     "D" : ["F"],
#     "E" : ["B"],
#     "F" : ["A"],
#     "G" : ["H", "E"],
#     "H" : ["A"]
#   }

# start_node = 'A'
# print("DFS traversal starting from node ", start_node, " : ", end="")
# dfs(graph, start_node)
# print()



