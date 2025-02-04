import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
from sklearn.metrics import accuracy_score, precision_score, recall_score, f1_score, confusion_matrix, classification_report
import matplotlib.pyplot as plt
import seaborn as sns

# Load your dataset
df = pd.read_excel('uploads/CleanedData.xlsx')

# Debugging: Check dataset before processing
print("Initial Dataset:")
print(df.head())
print(df.info())

# Drop irrelevant columns (e.g., Invoice)
df = df.drop(columns=['Invoice', 'Document Type', 'Customer Name'], errors='ignore')

# Debugging: Check dataset after dropping columns
print("Dataset after dropping irrelevant columns:")
print(df.head())
print(df.info())

# Convert categorical columns to numeric
df = pd.get_dummies(df, drop_first=True)

# Check for missing values
print("Missing values per column:")
print(df.isnull().sum())

# Drop rows with missing values
df = df.dropna()
print(f"Dataset shape after dropping NaNs: {df.shape}")

# Debugging: Ensure dataset isn't empty
if df.empty:
    print("Dataset is empty after preprocessing. Check input data and preprocessing steps.")
    exit()

# Separate features and target variable
X = df.iloc[:, :-1].values  # Features
y = df.iloc[:, -1].values   # Target

# Debugging: Check target variable
print(f"Unique target values: {set(y)}")
if len(y) == 0:
    print("Target variable is empty. Check the dataset and preprocessing steps.")
    exit()

# Split the dataset into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Check training and testing sets
print(f"Training set size: {len(X_train)}, Testing set size: {len(X_test)}")

# Initialize the model
model = DecisionTreeClassifier(random_state=42)

# Train the model
model.fit(X_train, y_train)

# Make predictions on the test set
y_pred = model.predict(X_test)

# Calculate evaluation metrics
accuracy = accuracy_score(y_test, y_pred)
precision = precision_score(y_test, y_pred, average='weighted', zero_division=0)
recall = recall_score(y_test, y_pred, average='weighted', zero_division=0)
f1 = f1_score(y_test, y_pred, average='weighted', zero_division=0)
conf_matrix = confusion_matrix(y_test, y_pred)
class_report = classification_report(y_test, y_pred, zero_division=0)

# Display evaluation metrics
print(f"Accuracy: {accuracy:.2f}")
print(f"Precision: {precision:.2f}")
print(f"Recall: {recall:.2f}")
print(f"F1 Score: {f1:.2f}")
print("\nConfusion Matrix:")
print(conf_matrix)
print("\nClassification Report:")
print(class_report)

# Plot confusion matrix
plt.figure(figsize=(8, 6))
sns.heatmap(conf_matrix, annot=True, fmt='d', cmap='Blues')
plt.xlabel('Predicted')
plt.ylabel('Actual')
plt.title('Confusion Matrix')
plt.show()

# Plot evaluation metrics
metrics = {'Accuracy': accuracy, 'Precision': precision, 'Recall': recall, 'F1 Score': f1}
plt.figure(figsize=(10, 5))
plt.bar(metrics.keys(), metrics.values(), color=['blue', 'green', 'red', 'purple'])
plt.xlabel('Metrics')
plt.ylabel('Scores')
plt.title('Evaluation Metrics')
plt.ylim(0, 1)
plt.show()
