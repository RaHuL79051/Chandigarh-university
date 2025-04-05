import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np
import pandas as pd

# 1. **Line Plot**
def line_plot():
    x = np.arange(1, 6)
    y = np.array([2, 4, 6, 8, 10])
    df = pd.DataFrame({'x': x, 'y': y})
    sns.lineplot(x='x', y='y', data=df, label="y = 2x")
    plt.title("Basic Line Plot")
    plt.xlabel("X-axis")
    plt.ylabel("Y-axis")
    plt.legend()
    plt.show()

# 2. **Bar Plot**
def bar_plot():
    categories = ['A', 'B', 'C', 'D']
    values = [3, 7, 2, 5]
    df = pd.DataFrame({'categories': categories, 'values': values})
    
    sns.barplot(x='categories', y='values', data=df)
    plt.title("Bar Plot")
    plt.xlabel("Categories")
    plt.ylabel("Values")
    plt.show()

# 3. **Scatter Plot**
def scatter_plot():
    x = np.array([1, 2, 3, 4, 5])
    y = np.array([10, 20, 25, 30, 40])
    df = pd.DataFrame({'x': x, 'y': y})
    
    sns.scatterplot(x='x', y='y', data=df, color='red')
    plt.title("Scatter Plot")
    plt.xlabel("X-axis")
    plt.ylabel("Y-axis")
    plt.show()

# 4. **Histogram**
def histogram_plot():
    data = np.random.randn(1000)
    df = pd.DataFrame({'data': data})
    
    sns.histplot(df['data'], kde=True, bins=30, color='blue')
    plt.title("Histogram")
    plt.xlabel("Value")
    plt.ylabel("Frequency")
    plt.show()



line_plot()
bar_plot()
scatter_plot()
histogram_plot()
