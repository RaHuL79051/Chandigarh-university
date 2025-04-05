import numpy as np
import matplotlib.pyplot as plt
import random
def onjective_function(x):
  return -x**2 + 10*x

def hill_climbing(max_iteration=100, step_size=0.5, lower_bound=0, upper_bound=10):
  # Initialize the starting point
  current_x = random.uniform(lower_bound, upper_bound)
  current_value= onjective_function(current_x)


  for _ in range(max_iteration):
    new_x = current_x + random.uniform(-step_size, step_size)
    new_x = max(lower_bound, min(upper_bound, new_x)) 
    new_y = onjective_function(new_x)

    if new_y > current_value:
      current_x, current_value = new_x, new_y

  return current_x, current_value


best_x, best_y = hill_climbing()
print(f"Best colution found: x = {best_x}, y = {best_y}")

x_value = np.linspace(0, 10, 100)
y_value = onjective_function(x_value)
plt.figure(figsize=(10, 6))
plt.plot(x_value, y_value, label='Objective Function')
plt.scatter(best_x, best_y, color='red', label='Best Solution')
plt.show()