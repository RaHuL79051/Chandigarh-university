import tkinter as tk
from tkinter import filedialog, messagebox
import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LogisticRegression, LinearRegression
from sklearn.tree import DecisionTreeClassifier
from sklearn.svm import SVC
import matplotlib.pyplot as plt

# Initialize Tkinter window
root = tk.Tk()
root.title("ML Predictor Hub")
root.geometry("500x400")

# Global variables
dataset = None
selected_model = None

# Function to load dataset
def load_dataset():
    global dataset
    file_path = filedialog.askopenfilename(filetypes=[("CSV files", "*.csv")])
    if file_path:
        dataset = pd.read_csv(file_path)
        messagebox.showinfo("Success", "Dataset Loaded Successfully!")

# Function to select ML model
def select_model(model_name):
    global selected_model
    selected_model = model_name
    messagebox.showinfo("Model Selected", f"You selected {model_name}")

# Function to train and predict
def train_and_predict():
    if dataset is None or selected_model is None:
        messagebox.showwarning("Warning", "Please load a dataset and select a model first.")
        return
    
    # Assuming last column is target
    X = dataset.iloc[:, :-1].values
    y = dataset.iloc[:, -1].values
    
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
    
    model = None
    if selected_model == "Logistic Regression":
        model = LogisticRegression()
    elif selected_model == "Linear Regression":
        model = LinearRegression()
    elif selected_model == "Decision Tree":
        model = DecisionTreeClassifier()
    elif selected_model == "SVM":
        model = SVC()
    
    model.fit(X_train, y_train)
    y_pred = model.predict(X_test)
    
    # Plot results
    plt.figure(figsize=(6,4))
    plt.scatter(y_test, y_pred, alpha=0.5, color='blue')
    plt.xlabel("Actual Values")
    plt.ylabel("Predicted Values")
    plt.title(f"{selected_model} Predictions")
    plt.show()
    
    messagebox.showinfo("Training Complete", f"Model trained successfully! Check the plot.")

# UI Elements
tk.Button(root, text="Load Dataset", command=load_dataset).pack(pady=10)

models = ["Logistic Regression", "Linear Regression", "Decision Tree", "SVM"]
for model in models:
    tk.Button(root, text=model, command=lambda m=model: select_model(m)).pack(pady=5)

tk.Button(root, text="Train & Predict", command=train_and_predict).pack(pady=10)

root.mainloop()
