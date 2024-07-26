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

# Function to update PowerPoint presentation with new image and analysis results
def update_presentation(user_id, image_path, analysis_text):
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

    # Add the image slide
    slide = prs.slides.add_slide(prs.slide_layouts[5])
    slide.shapes.add_picture(image_path, Inches(1), Inches(1), width=Inches(8), height=Inches(5.5))

    # Add analysis text on a new slide
    analysis_slide = prs.slides.add_slide(prs.slide_layouts[5])
    textbox = analysis_slide.shapes.add_textbox(Inches(1), Inches(1), Inches(8), Inches(5.5))
    text_frame = textbox.text_frame
    p = text_frame.add_paragraph()
    p.text = analysis_text
    p.font.size = Inches(0.2)  # Reduced font size for analysis text

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

# Define the churn period (e.g., 6 months)
churn_period_months = 6

# Extract relevant columns and ensure dates are in datetime format
df['Invoice Date'] = pd.to_datetime(df['Invoice Date'], errors='coerce')
df['Billing Date'] = pd.to_datetime(df['Billing Date'], errors='coerce')

# Get the current date (assumed to be the date of analysis)
current_date = pd.Timestamp.now()

# Identify the date range for churn calculation
churn_cutoff_date = current_date - pd.DateOffset(months=churn_period_months)

# Get monthly churn and active customer counts
df['Month'] = df['Billing Date'].dt.to_period('M')
monthly_data = df.groupby(['Month', 'Customer Name']).size().reset_index(name='Count')
monthly_data['Active'] = monthly_data['Month'].apply(lambda x: x >= churn_cutoff_date.to_period('M'))

# Pivot the data for stacked bar chart
pivot_data = monthly_data.pivot_table(index='Month', columns='Active', values='Count', aggfunc='sum').fillna(0)

# Plot the stacked bar chart
plt.figure(figsize=(10, 8))
pivot_data.plot(kind='bar', stacked=True, color=['green', 'red'], edgecolor='black')

plt.xlabel("Month", fontsize=14)
plt.ylabel("Number of Customers", fontsize=14)
plt.title("Churn and Active Customers Over Time", fontsize=16)
plt.xticks(rotation=90)
plt.legend(["Active", "Churned"], title="Customer Status")
plt.tight_layout()

# Save the plot as a static image
output_dir = os.path.join('C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\images')
if not os.path.exists(output_dir):
    os.makedirs(output_dir)
plot_path = os.path.join(output_dir, 'churn_rate_stacked_bar_chart.png')
plt.savefig(plot_path, facecolor='white')
plt.close()

print(f'Stacked bar chart for churn rate saved to {plot_path}')

# Define user ID and image type
user_id = 1  # Replace with actual user ID
image_type = "Churn Rate"

# Save or update image details in the database
save_or_update_image_in_db(user_id, plot_path, image_type)

# Example analysis text
analysis_text = "This chart shows the churn and active customer counts over time. The red portion represents churned customers, while the green portion represents active customers."

# Update PowerPoint presentation with the new image and analysis results
update_presentation(user_id, plot_path, analysis_text)
