import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LogisticRegression
from sklearn.metrics import accuracy_score, confusion_matrix, classification_report
import matplotlib.pyplot as plt

X = np.array([
  [2.5, 2.4],
  [1.0, 1.2],
  [3.5, 3.2],
  [5.0, 3.0],
  [4.5, 5.0],
  [6.0, 4.5],
  [7.8, 5.0],
  [4.8, 4.5]
])

y = np.array([0, 0, 0, 1, 1, 1, 1, 1])

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.25)

model = LogisticRegression()
model.fit(X_train, y_train)

y_pred = model.predict(X_test)

accuracy = accuracy_score(y_test, y_pred)
conf_matrix = confusion_matrix(y_test, y_pred)
print("Accuracy :", accuracy) 


# z = np.linspace(-10, 10, 100)
# sigmoid = 1 / (1 + np.exp(-z))

# plt.plot(z, sigmoid)
# plt.title("Sigmoid Function")
# plt.xlabel("z")
# plt.ylabel("Sigmoid Output")
# plt.show() 