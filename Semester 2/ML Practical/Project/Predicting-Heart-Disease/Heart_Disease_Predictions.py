import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
from matplotlib.figure import Figure
import seaborn as sns
import tkinter as tk
from tkinter import ttk, messagebox, filedialog
from sklearn.neighbors import KNeighborsClassifier
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import cross_val_score
from sklearn.preprocessing import StandardScaler
import io


class HeartDiseaseApp:
    def __init__(self, root):
        self.root = root
        self.root.title("❤️ Heart Disease Prediction Analysis")
        self.root.geometry("1200x800")
        self.root.configure(bg="#f8f9fa")

        # Custom style configuration
        self.setup_styles()

        # Header Frame
        self.header_frame = ttk.Frame(root, style="Header.TFrame")
        self.header_frame.pack(fill="x", padx=10, pady=(10, 0))

        ttk.Label(self.header_frame, text="Heart Disease Prediction",
                  style="Header.TLabel").pack(side="left", padx=10)

        # Create notebook (tabs)
        self.notebook = ttk.Notebook(root, style="TNotebook")
        self.notebook.pack(fill='both', expand=True, padx=10, pady=10)

        # Create tabs
        self.tab_data = ttk.Frame(self.notebook, style="TFrame")
        self.tab_visualization = ttk.Frame(self.notebook, style="TFrame")
        self.tab_model = ttk.Frame(self.notebook, style="TFrame")

        self.notebook.add(self.tab_data, text="📂 Data Explorer")
        self.notebook.add(self.tab_visualization, text="📊 Data Visualizer")
        self.notebook.add(self.tab_model, text="🧠 Model Trainer")

        # Initialize Variables
        self.dataset = None
        self.X = None
        self.y = None
        self.original_df = None

        # Setup UI Components
        self.setup_data_tab()
        self.setup_visualization_tab()
        self.setup_model_tab()

    def setup_styles(self):
        """Configure custom styles for widgets"""
        style = ttk.Style()

        # Main style configurations
        style.configure("TFrame", background="#f8f9fa")
        style.configure("TLabel", background="#f8f9fa", font=("Segoe UI", 10))
        style.configure("TButton", font=("Segoe UI", 10, "bold"), padding=6)
        style.configure("TNotebook", background="#f8f9fa", borderwidth=0)
        style.configure("TNotebook.Tab", font=("Segoe UI", 10, "bold"), padding=[10, 5])

        # Custom styles
        style.configure("Header.TFrame", background="#dc3545")
        style.configure("Header.TLabel", background="#dc3545",
                        foreground="white", font=("Segoe UI", 14, "bold"))

        style.configure("Primary.TButton", background="#007bff", foreground="black")
        style.configure("Secondary.TButton", background="#6c757d", foreground="black")
        style.configure("Success.TButton", background="#28a745", foreground="black")

        style.map("Primary.TButton",
                  background=[("active", "#0069d9")])
        style.map("Secondary.TButton",
                  background=[("active", "#5a6268")])
        style.map("Success.TButton",
                  background=[("active", "#218838")])

        style.configure("Info.TFrame", background="#e2e3e5", relief="sunken", borderwidth=1)
        style.configure("Info.TLabel", background="#e2e3e5", font=("Segoe UI", 9))

    def setup_data_tab(self):
        """Creates UI for the Data Tab"""
        # Main container frame
        container = ttk.Frame(self.tab_data)
        container.pack(fill="both", expand=True, padx=10, pady=10)

        # Left panel - Actions
        left_panel = ttk.Frame(container, width=200, style="Info.TFrame")
        left_panel.pack(side="left", fill="y", padx=(0, 10))
        left_panel.pack_propagate(False)

        ttk.Label(left_panel, text="Data Actions", style="Header.TLabel").pack(pady=10)

        ttk.Button(left_panel, text="📂 Load Dataset",
                   command=self.load_dataset,
                   style="Primary.TButton").pack(fill="x", padx=5, pady=5)

        ttk.Separator(left_panel, orient="horizontal").pack(fill="x", pady=10)

        ttk.Label(left_panel, text="Dataset Info:", style="Info.TLabel").pack(anchor="w", padx=5)

        self.stats_label = ttk.Label(left_panel, text="No data loaded", style="Info.TLabel", wraplength=180)
        self.stats_label.pack(fill="x", padx=5, pady=5)

        # Right panel - Data display
        right_panel = ttk.Frame(container)
        right_panel.pack(side="right", fill="both", expand=True)

        # Dataset Info Section
        info_frame = ttk.LabelFrame(right_panel, text="Dataset Information", padding=10)
        info_frame.pack(fill="both", expand=True, pady=(0, 10))

        self.info_text = tk.Text(info_frame, height=15, wrap="none", bg="white",
                                 font=("Consolas", 10), padx=5, pady=5)
        self.info_text.pack(fill="both", expand=True)

        # Add Scrollbar
        scroll_y = ttk.Scrollbar(info_frame, orient="vertical", command=self.info_text.yview)
        self.info_text.configure(yscrollcommand=scroll_y.set)
        scroll_y.pack(side="right", fill="y")

    def setup_visualization_tab(self):
        """Creates UI for the Visualization Tab"""
        # Main container frame
        container = ttk.Frame(self.tab_visualization)
        container.pack(fill="both", expand=True, padx=10, pady=10)

        # Left panel - Visualization controls
        left_panel = ttk.Frame(container, width=200, style="Info.TFrame")
        left_panel.pack(side="left", fill="y", padx=(0, 10))
        left_panel.pack_propagate(False)

        ttk.Label(left_panel, text="Visualization Tools", style="Header.TLabel").pack(pady=10)

        ttk.Button(left_panel, text="🔥 Correlation Heatmap",
                   command=lambda: self.show_visualization("heatmap"),
                   style="Primary.TButton").pack(fill="x", padx=5, pady=5)

        ttk.Button(left_panel, text="📈 Feature Distribution",
                   command=lambda: self.show_visualization("hist"),
                   style="Primary.TButton").pack(fill="x", padx=5, pady=5)

        ttk.Button(left_panel, text="🎯 Target Distribution",
                   command=lambda: self.show_visualization("target"),
                   style="Primary.TButton").pack(fill="x", padx=5, pady=5)

        ttk.Separator(left_panel, orient="horizontal").pack(fill="x", pady=10)

        ttk.Label(left_panel, text="Visualization Options:", style="Info.TLabel").pack(anchor="w", padx=5)

        # Right panel - Plot display
        right_panel = ttk.Frame(container)
        right_panel.pack(side="right", fill="both", expand=True)

        # Frame for Plots
        self.plot_frame = ttk.Frame(right_panel, padding=10)
        self.plot_frame.pack(fill="both", expand=True)

        # Placeholder for when no visualization is shown
        self.placeholder_label = ttk.Label(self.plot_frame,
                                           text="Select a visualization from the left panel",
                                           style="Info.TLabel")
        self.placeholder_label.pack(expand=True)

    def setup_model_tab(self):
        """Creates UI for Model Training Tab"""
        # Main container frame
        container = ttk.Frame(self.tab_model)
        container.pack(fill="both", expand=True, padx=10, pady=10)

        # Left panel - Model controls
        left_panel = ttk.Frame(container, width=200, style="Info.TFrame")
        left_panel.pack(side="left", fill="y", padx=(0, 10))
        left_panel.pack_propagate(False)

        ttk.Label(left_panel, text="Model Training", style="Header.TLabel").pack(pady=10)

        ttk.Button(left_panel, text="🔍 Evaluate KNN",
                   command=self.evaluate_knn,
                   style="Success.TButton").pack(fill="x", padx=5, pady=5)

        ttk.Button(left_panel, text="🌳 Evaluate Random Forest",
                   command=self.evaluate_rf,
                   style="Success.TButton").pack(fill="x", padx=5, pady=5)

        ttk.Separator(left_panel, orient="horizontal").pack(fill="x", pady=10)

        ttk.Label(left_panel, text="Model Information:", style="Info.TLabel").pack(anchor="w", padx=5)

        # Right panel - Results display
        right_panel = ttk.Frame(container)
        right_panel.pack(side="right", fill="both", expand=True)

        # Results Section
        results_frame = ttk.LabelFrame(right_panel, text="📊 Model Results", padding=10)
        results_frame.pack(fill="both", expand=True)

        self.results_text = tk.Text(results_frame, height=15, bg="white",
                                    font=("Consolas", 10), padx=5, pady=5)
        self.results_text.pack(fill="both", expand=True)

        # Add Scrollbar for Results
        scroll_y = ttk.Scrollbar(results_frame, orient="vertical", command=self.results_text.yview)
        self.results_text.configure(yscrollcommand=scroll_y.set)
        scroll_y.pack(side="right", fill="y")

    def load_dataset(self):
        """Loads the CSV dataset"""
        file_path = filedialog.askopenfilename(filetypes=[("CSV files", "*.csv")])
        if file_path:
            try:
                self.original_df = pd.read_csv(file_path)
                self.dataset = self.original_df.copy()
                self.preprocess_data()

                self.info_text.delete(1.0, tk.END)
                self.info_text.insert(tk.END, f"Shape: {self.original_df.shape}\n\n")

                buffer = io.StringIO()
                self.original_df.info(buf=buffer)
                self.info_text.insert(tk.END, buffer.getvalue())

                # Update stats label
                self.stats_label.config(
                    text=f"Loaded: {self.original_df.shape[0]} rows\n{self.original_df.shape[1]} features")

                # Clear any existing visualizations
                for widget in self.plot_frame.winfo_children():
                    widget.destroy()
                self.placeholder_label = ttk.Label(self.plot_frame,
                                                   text="Select a visualization from the left panel",
                                                   style="Info.TLabel")
                self.placeholder_label.pack(expand=True)

                messagebox.showinfo("✅ Success", "Dataset loaded successfully!")
            except Exception as e:
                messagebox.showerror("❌ Error", f"Failed to load dataset: {str(e)}")

    def preprocess_data(self):
        if self.original_df is not None:
            self.dataset = self.original_df.copy()

            # Ensure the target variable is categorical
            if 'target' in self.dataset.columns:
                self.dataset['target'] = self.dataset['target'].astype(int)  # Convert to integer

            # Normalize numerical features (excluding target)
            standardScaler = StandardScaler()
            numeric_cols = [col for col in self.dataset.columns if
                            col != 'target' and self.dataset[col].dtype in ['float64', 'int64']]
            self.dataset[numeric_cols] = standardScaler.fit_transform(self.dataset[numeric_cols])

            self.y = self.dataset['target']  # Now correctly categorized
            self.X = self.dataset.drop(['target'], axis=1)  # Features

    def show_visualization(self, vis_type):
        """Displays plots for data visualization"""
        if self.original_df is None:
            messagebox.showwarning("⚠️ Warning", "Please load a dataset first!")
            return

        # Clear the plot frame
        for widget in self.plot_frame.winfo_children():
            widget.destroy()

        fig, ax = plt.subplots(figsize=(8, 6))

        if vis_type == "hist":
            fig.clear()
            cols = self.original_df.select_dtypes(include=['int64', 'float64']).columns[:9]
            rows = int(np.ceil(len(cols) / 3))
            axes = fig.subplots(rows, 3)

            if rows == 1:
                axes = np.array([axes])

            for i, col in enumerate(cols):
                row_idx, col_idx = divmod(i, 3)
                ax = axes[row_idx, col_idx]
                ax.hist(self.original_df[col], bins=15, color='skyblue', edgecolor='black')
                ax.set_title(col)

            for i in range(len(cols), rows * 3):
                fig.delaxes(axes.flat[i])

            fig.tight_layout()

        elif vis_type == "target":
            ax = fig.add_subplot(111)
            sns.countplot(x='target', data=self.original_df, hue='target', palette='viridis', ax=ax, legend=False)
            ax.set_title("Target Variable Distribution")

        elif vis_type == "heatmap":
            ax = fig.add_subplot(111)
            sns.heatmap(self.original_df.corr(), annot=True, cmap="coolwarm", ax=ax)
            ax.set_title("Correlation Heatmap")

        # Embed the plot in Tkinter
        canvas = FigureCanvasTkAgg(fig, master=self.plot_frame)
        canvas.draw()
        canvas.get_tk_widget().pack(fill="both", expand=True)

    def evaluate_knn(self):
        if self.X is None or self.y is None:
            messagebox.showwarning("Warning", "Please load and preprocess a dataset first!")
            return

        self.results_text.delete(1.0, tk.END)
        self.results_text.insert(tk.END, "Evaluating KNN Classifier...\n")
        self.root.update()

        knn_scores = []
        for k in range(1, 21):
            knn_classifier = KNeighborsClassifier(n_neighbors=k)
            score = cross_val_score(knn_classifier, self.X, self.y, cv=10)
            knn_scores.append(score.mean())
            self.results_text.insert(tk.END, f"K={k}: {score.mean():.4f}\n")
            self.root.update()

        # **Fix: Use self.plot_frame instead of self.knn_plot_frame**
        for widget in self.plot_frame.winfo_children():
            widget.destroy()

        fig = Figure(figsize=(8, 4))
        canvas = FigureCanvasTkAgg(fig, master=self.plot_frame)
        canvas.get_tk_widget().pack(fill='both', expand=True)

        ax = fig.add_subplot(111)
        ax.plot([k for k in range(1, 21)], knn_scores, color='red')
        for i in range(1, 21):
            ax.text(i, knn_scores[i - 1], (i, round(knn_scores[i - 1], 3)))
        ax.set_xticks([i for i in range(1, 21)])
        ax.set_xlabel('Number of Neighbors (K)')
        ax.set_ylabel('Scores')
        ax.set_title('K Neighbors Classifier Scores for Different K Values')

        canvas.draw()

        best_k = np.argmax(knn_scores) + 1
        self.results_text.insert(tk.END, f"\nBest K value: {best_k} with score: {max(knn_scores):.4f}\n")

    def evaluate_rf(self):
        if self.X is None or self.y is None:
            messagebox.showwarning("Warning", "Please load and preprocess a dataset first!")
            return

        self.results_text.delete(1.0, tk.END)
        self.results_text.insert(tk.END, "Evaluating Random Forest Classifier...\n")
        self.root.update()

        randomforest_classifier = RandomForestClassifier(n_estimators=10)
        score = cross_val_score(randomforest_classifier, self.X, self.y, cv=10).mean()

        self.results_text.insert(tk.END, f"\nAverage Random Forest Cross-Validation Score: {score:.4f}\n")


if __name__ == "__main__":
    root = tk.Tk()
    app = HeartDiseaseApp(root)
    root.mainloop()