import numpy as np
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_squared_error,   r2_score
import matplotlib.pyplot as plt


url = "https://raw.githubusercontent.com/mwaskom/seaborn-data/master/iris.csv"

df = pd.read_csv(url)
print(df.head())

X = df[['sepal_width']]
y = df['sepal_length']

X_train, X_test, y_train, y_test = train_test_split(X, y)

model = LinearRegression()
model.fit(X_train, y_train)

y_pred = model.predict(X_test)

MSC = mean_squared_error(y_test, y_pred)
RMSC = np.sqrt(MSC)
R2 = r2_score(y_test, y_pred)

print("MSC: ", MSC) 
print("RMSC: ", RMSC)
print("R2: ", R2)

plt.scatter(y_test, y_pred, color='blue', alpha=0.5)
plt.plot([y_test.min(), y_test.max()],[y_test.min(), y_test.max()], color='red', linestyle='--')
plt.xlabel('Actual Prices')
plt.ylabel('Predicted Prices')
plt.show()  