import pandas as pd
from sklearn.tree import DecisionTreeClassifier, export_text
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score, confusion_matrix
from sklearn.tree import export_graphviz 
from graphviz import Source
url = "https://raw.githubusercontent.com/jbrownlee/Datasets/master/iris.csv"
columns = ['Feature1', 'Feature2', 'Feature3', 'Feature4', 'Label']
df = pd.read_csv(url, names=columns)
print(df.head())
X = df.iloc[:, :-1]
y = df.iloc[:, -1]
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=42)
clf = DecisionTreeClassifier(criterion='gini')
clf.fit(X_train, y_train)
y_pred = clf.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
cm = confusion_matrix(y_test, y_pred)
print("Confusion Matrix:")
print(cm)
print(f"Accuracy of the Decision Tree model: {accuracy * 100:.2f}%")
dot_data = export_graphviz(clf, out_file=None, feature_names=X.columns, class_names=clf.classes_,
                           filled=True, rounded=True, special_characters=True)
graph = Source(dot_data)
graph.render("decision_tree", format="png", view=True)
print("Decision Tree Rules:")
tree_rules = export_text(clf, feature_names=list(X.columns))
print(tree_rules)
