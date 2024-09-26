import pandas as pd
import matplotlib.pyplot as plt
import os
import mysql.connector
from pptx import Presentation
from pptx.util import Inches
import json

# Database connection function
def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="loginandanalysis"
    )

# Function to save image details to the database
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
files = os.listdir(uploads_dir)
excel_files = [file for file in files if file.endswith('.xlsx')]

if not excel_files:
    raise FileNotFoundError("No Excel file found in the uploads directory.")

excel_file_path = os.path.join(uploads_dir, excel_files[0])
df = pd.read_excel(excel_file_path)

# Filter relevant columns
relevant_cols = ["Product", "Revenue Billed"]
df = df[relevant_cols]

# Aggregate Revenue by Product
revenue_by_product = df.groupby("Product")["Revenue Billed"].sum().reset_index()

# Bar chart with white background
plt.figure(figsize=(10, 8), facecolor='white')
plt.bar(revenue_by_product["Product"], revenue_by_product["Revenue Billed"], color='skyblue')
plt.xlabel("Product", fontsize=10, color='black')
plt.ylabel("Total Revenue Billed", fontsize=10, color='black')
plt.title("Total Revenue by Product", fontsize=12, color='black')
plt.xticks(rotation=45, ha="right", fontsize=10, color='black')
plt.yticks(fontsize=10, color='black')
plt.gca().set_facecolor('white')
plt.gca().spines['top'].set_color('black')
plt.gca().spines['right'].set_color('black')
plt.gca().spines['left'].set_color('black')
plt.gca().spines['bottom'].set_color('black')

plt.tight_layout()

# Save the plot as a static image
output_dir = os.path.join('C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images')
if not os.path.exists(output_dir):
    os.makedirs(output_dir)
plot_path = os.path.join(output_dir, 'revenue_by_product_bar_chart.png')
plt.savefig(plot_path, facecolor='white')
plt.close()

# Define user ID and image type
user_id = 1
image_type = "Revenue by Product"

# Save image details to the database
save_or_update_image_in_db(user_id, plot_path, image_type)


