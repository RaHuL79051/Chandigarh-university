import math

# Square root
num = 16
sqrt_num = math.sqrt(num)
print(f"Square root of {num} is {sqrt_num}")

# Exponentiation
base = 2
exponent = 3
power = math.pow(base, exponent)
print(f"{base} raised to the power of {exponent} is {power}")

# Factorial
num = 5
factorial_result = math.factorial(num)
print(f"The factorial of {num} is {factorial_result}")

# PI Value
print(f"The value of Pi is {math.pi}")

# Trigonometric functions
angle_degrees = 45
angle_radians = math.radians(angle_degrees)

sin_value = math.sin(angle_radians)
cos_value = math.cos(angle_radians)
tan_value = math.tan(angle_radians)

print(f"Sin({angle_degrees}°) = {sin_value}")
print(f"Cos({angle_degrees}°) = {cos_value}")
print(f"Tan({angle_degrees}°) = {tan_value}")

# LOG
num = 1000

log_base_10 = math.log10(num)
natural_log = math.log(num)

print(f"Log base 10 of {num} is {log_base_10}")
print(f"Natural logarithm of {num} is {natural_log}")