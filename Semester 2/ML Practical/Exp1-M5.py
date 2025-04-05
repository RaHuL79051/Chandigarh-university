from scipy import optimize

def func(x):
    return x**2 + 5*x + 6

result = optimize.minimize(func, 0)
print(result.x)