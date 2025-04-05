import matplotlib.pyplot as plt

# Line plot
x = [11, 98, 21, 43, 48]
y = [2, 7, 6, 1, 15]

plt.plot(x, y, label='y = 2x')
plt.xlabel('X-axis')
plt.ylabel('Y-axis')
plt.title('Basic Line Plot')
plt.show()

# Bar Plot
x = ['A', 'B', 'C', 'D']
y = [30, 15, 8, 12]

plt.bar(x, y)
plt.xlabel('Categories')
plt.ylabel('Values')
plt.title('Basic Bar Plot')
plt.show()

# Pie Plot
sizes = [15, 30, 45, 10]
labels = ['A', 'B', 'C', 'D']

plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.title('Basic Pie Plot')
plt.show()

# Scatter Plot
x = [11, 98, 21, 43, 48]
y = [2, 7, 6, 1, 15]

plt.scatter(x, y)
plt.xlabel('X-axis')
plt.ylabel('Y-axis')
plt.title('Basic Scatter Plot')
plt.show()

