import pandas as pd
import matplotlib.pyplot as plt
import os
import mysql.connector
from pptx import Presentation
from pptx.util import Inches
from sklearn.preprocessing import StandardScaler
from sklearn.cluster import KMeans
import json

servername = "sql12.freesqldatabase.com"
username = "sql12756836"
password = "qEaH9rPgZn"
database = "sql12756836"

def get_db_connection():
    return mysql.connector.connect(
        host=servername,
        user=username,
        password=password,
        database=database
    )


# Function to save or update image details in the database
def save_or_update_image_in_db(user_id, image_path, image_type):
    conn = get_db_connection()
    cursor = conn.cursor()

    cursor.execute(
        "SELECT id FROM user_images WHERE user_id = %s AND image_path = %s AND image_type = %s",
        (user_id, image_path, image_type)
    )
    result = cursor.fetchone()

    if result:
        cursor.execute(
            "UPDATE user_images SET image_path = %s WHERE id = %s",
            (image_path, result[0])
        )
    else:
        cursor.execute(
            "INSERT INTO user_images (user_id, image_path, image_type) VALUES (%s, %s, %s)",
            (user_id, image_path, image_type)
        )

    conn.commit()
    cursor.close()
    conn.close()



# Read the dataset from Excel
uploads_dir = "uploads"

# List all files in the uploads directory
files = os.listdir(uploads_dir)

# Identify Excel files that contain "CleanedData" (case-insensitive) in the filename
excel_files = [file for file in files if file.endswith('.xlsx') and 'cleaneddata' in file.lower()]

# Ensure we have at least one matching file
if not excel_files:
    raise FileNotFoundError("No Excel file containing 'CleanedData' found in the uploads directory.")

# Pick the first matched file
selected_file = os.path.join(uploads_dir, excel_files[0])



# Check if there is at least one Excel file
if not excel_files:
    raise FileNotFoundError("No Excel file found in the uploads directory.")

# Read the first Excel file found
excel_file_path = os.path.join(uploads_dir, excel_files[0])
df = pd.read_excel(excel_file_path)

# Select features for clustering, converting categorical variables using one-hot encoding
filtered_df = df[['Revenue Billed', 'Item Name', 'Quantity Billed']].dropna().copy()

# One-hot encode the 'Item Name' column
filtered_df = pd.get_dummies(filtered_df, columns=['Item Name'], drop_first=True)

# Standardize the features
scaler = StandardScaler()
scaled_features = scaler.fit_transform(filtered_df)

# Define the number of clusters
optimal_n_clusters = 5  # Set the number of clusters as per your requirement

# Apply K-means clustering with the defined number of clusters
kmeans = KMeans(n_clusters=optimal_n_clusters, n_init=10, random_state=42)
clusters = kmeans.fit_predict(scaled_features)

# Ensure the number of rows match before assignment
filtered_df['Cluster'] = clusters

# Merge the clustered data back into the original DataFrame
df = df.merge(filtered_df[['Cluster']], left_index=True, right_index=True, how='left')
# Ensure 'Item Name' is a string and fill NaN values with a placeholder
df['Item Name'] = df['Item Name'].astype(str).fillna("Unknown")

# Visualize the clusters
plt.figure(figsize=(10, 9))
scatter = plt.scatter(df['Revenue Billed'], df['Item Name'], c=df['Cluster'], cmap='viridis', marker='o')
plt.colorbar(scatter, label='Cluster')
plt.title('Item Name by Revenue Billed')
plt.xlabel('Revenue Billed')
plt.ylabel('Item Name')
plt.xticks(rotation=45)  # Rotate x-axis labels for better visibility if needed
plt.subplots_adjust(left=0.3, right=1, top=0.9, bottom=0.1)  # More space on left, less on right


# Save the plot
plot_path = os.path.join('C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images', 'churn_rate_stacked_bar_chart.png')
plt.savefig(plot_path, facecolor='white')
plt.close()

print(f'K-means clustering plot saved to {plot_path}')

# Define user ID and image type
user_id = 1  # Replace with actual user ID
image_type = "Churn Rate"

# Save or update image details in the database
save_or_update_image_in_db(user_id, plot_path, image_type)
