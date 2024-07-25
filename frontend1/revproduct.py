import pandas as pd
import matplotlib.pyplot as plt
import os
import mysql.connector
from pptx import Presentation
from pptx.util import Inches

# Database connection function
def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="loginandanalysis"
    )

# Function to save image details to the database
def save_image_to_db(user_id, image_path, image_type):
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute(
        "INSERT INTO user_images (user_id, image_path, image_type) VALUES (%s, %s, %s)",
        (user_id, image_path, image_type)
    )
    conn.commit()
    cursor.close()
    conn.close()

# Function to update PowerPoint presentation with new image
def update_presentation(user_id, image_path):
    conn = get_db_connection()
    cursor = conn.cursor()

    # Fetch or create the presentation for the user
    cursor.execute("SELECT presentation_path FROM user_presentations WHERE user_id = %s", (user_id,))
    result = cursor.fetchone()

    if result:
        ppt_path = result[0]
    else:
        ppt_path = f'static/presentations/user{user_id}_presentation.pptx'
        prs = Presentation()
        prs.save(ppt_path)
        cursor.execute(
            "INSERT INTO user_presentations (user_id, presentation_path) VALUES (%s, %s)",
            (user_id, ppt_path)
        )
        conn.commit()

    prs = Presentation(ppt_path)
    slide = prs.slides.add_slide(prs.slide_layouts[5])
    slide.shapes.add_picture(image_path, Inches(1), Inches(1), width=Inches(8), height=Inches(5.5))
    prs.save(ppt_path)

    cursor.close()
    conn.close()

# Read the dataset from Excel
uploads_dir = "uploads"

# List all files in the uploads directory
files = os.listdir(uploads_dir)

# Identify the Excel file (assuming there is only one Excel file in the directory)
excel_files = [file for file in files if file.endswith('.xlsx')]

# Check if there is at least one Excel file
if not excel_files:
    raise FileNotFoundError("No Excel file found in the uploads directory.")

# Read the first Excel file found
excel_file_path = os.path.join(uploads_dir, excel_files[0])
df = pd.read_excel(excel_file_path)

# Filter relevant columns
df = df[['Product', 'Revenue Billed']]

# Aggregate Revenue by Product
revenue_by_product = df.groupby('Product')['Revenue Billed'].sum().reset_index()

# print on Visula studio code console
print("Aggregated Revenue by Product:")
print(revenue_by_product)




# Pie chart
plt.figure(figsize=(10, 8))
plt.pie(revenue_by_product['Revenue Billed'], labels=revenue_by_product['Product'], 
        autopct='%1.1f%%', startangle=140, colors=plt.cm.Paired(range(len(revenue_by_product))))
plt.title('Revenue Billed by Product', fontsize=12, color='black')  # Set title color to black
plt.axis('equal')  # Equal aspect ratio ensures that pie is drawn as a circle.

# Save the plot as a static image
output_dir = os.path.join('C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images')
if not os.path.exists(output_dir):
    os.makedirs(output_dir)
plot_path = os.path.join(output_dir, 'revenue_by_product_pie_chart.png')
plt.savefig(plot_path, facecolor='white')  # Save the figure with white background
plt.close()

print(f'Pie chart for revenue billed by product saved to {plot_path}')

# Define user ID and image type
user_id = 1  # Replace with actual user ID
image_type = "Revenue by Product"

# Save image details to the database
save_image_to_db(user_id, plot_path, image_type)

# Update PowerPoint presentation with the new image
update_presentation(user_id, plot_path)
