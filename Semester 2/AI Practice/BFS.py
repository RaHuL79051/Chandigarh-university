from collections import deque

graph = {
    "1": ["5", "4", "2"],
    "2": ["7", "6", "1", "3"],
    "3": ["2"],
    "4": ["1"],
    "5": ["1"],
    "6": ["2"],
    "7": ["2"]
}

StartNode = "1"

def BFS(graph, StartNode):
  visited = set()
  queue = deque([StartNode])
  bfs_order = []
  while queue:
    node = queue.popleft()
    if node not in visited:
      visited.add(node)
      bfs_order.append(node)
      for i in graph[node]:
        if i not in visited:
          queue.append(i)
  return bfs_order

BFS_result = BFS(graph, StartNode)
print("The starting from node", StartNode, " : ", BFS_result)
