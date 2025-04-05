import numpy as np

# Array operations
arr = np.array([1, 2, 3, 4, 5])

print(f"Array: {arr}")
print(f"Sum of elements: {np.sum(arr)}")
print(f"Mean of elements: {np.mean(arr)}")
print(f"Standard deviation: {np.std(arr)}")

arr1 = np.arange(0, 10, 2)
print(f"Array using arange: {arr1}")

arr2 = np.linspace(0, 1, 5)
print(f"Array using linspace: {arr2}")

# Matrix operations

A = np.array([[1, 2], [3, 4]])
B = np.array([[5, 6], [7, 8]])

# Matrix addition
C = np.add(A, B)
print(f"Matrix Addition:\n{C}")

# Matrix multiplication
D = np.dot(A, B)
print(f"Matrix Multiplication:\n{D}")

# Reshape Array
arr2 = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9])

reshaped_arr = arr2.reshape(3, 3)
print(f"Reshaped Array (3x3):\n{reshaped_arr}")

# Min and Max Value in Array
arr3 = np.array([5, 8, 2, 10, 7])

min_val = np.min(arr3)
max_val = np.max(arr3)
print(f"Minimum value: {min_val}, Maximum value: {max_val}")
