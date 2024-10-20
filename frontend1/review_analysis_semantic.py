import pandas as pd
import matplotlib.pyplot as plt
import os
import json
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


# Load the dataset
#uploads_dir = "review"
uploads_dir = "c:\\xampp\\htdocs\\fyp0.3\\frontend1\\uploads"

# Check if the directory exists
if not os.path.exists(uploads_dir):
    raise FileNotFoundError(f"The directory {uploads_dir} does not exist.")

# List all files in the review directory
files = os.listdir(uploads_dir)
print("Files in directory:", files)  # Debug line to see files in the directory

# Identify the Excel file (assuming there is only one Excel file in the directory)
excel_files = [file for file in files if file.endswith('.xlsx')]

if not excel_files:
    raise FileNotFoundError("No Excel file found in the review directory.")

excel_file_path = os.path.join(uploads_dir, excel_files[0])
df = pd.read_excel(excel_file_path)

# Ensure static/images/ exists
output_dir_json = 'review/'
output_dir = 'static/images/'
if not os.path.exists(output_dir):
    os.makedirs(output_dir)

# Semantic analysis storage
semantic_analysis = {
    'revenue_by_item_currency': '',
    'revenue_quantity_by_bu': '',
    'top_customers_by_revenue': '',
}

# Define user ID
user_id = 1  # Replace with actual user ID

# 1. Revenue by Item Name and Currency
revenue_item_currency = df.groupby(['Item Name', 'Currency'])['Revenue Billed'].sum().unstack()
ax = revenue_item_currency.plot(kind='bar', stacked=True, figsize=(20, 16))
plt.title('Revenue by Item Name and Currency',fontsize=20)
plt.ylabel('Revenue Billed',fontsize=20)
plt.xticks(rotation=90)  # Rotate x-axis labels
plt.xticks( fontsize=20, color='black')
plt.yticks(fontsize=20, color='black')
plt.tight_layout()  # Adjust layout to prevent clipping
image_path_1 = output_dir + 'revenue_by_item_currency.png'
plt.savefig(image_path_1, bbox_inches='tight', dpi=50)
plt.close()

# Save image details to the database
save_or_update_image_in_db(user_id, image_path_1, 'Revenue by Item and Currency')

# Find top items and currencies with significant revenue
item_totals = revenue_item_currency.sum(axis=1)
top_items = item_totals.nlargest(2).index
top_currencies = {item: revenue_item_currency.loc[item].idxmax() for item in top_items}

top_item_x, top_item_y = top_items[0], top_items[1]
top_currency_x, top_currency_y = top_currencies.get(top_item_x, 'Unknown'), top_currencies.get(top_item_y, 'Unknown')

# Add semantic analysis for revenue by item name and currency
semantic_analysis['revenue_by_item_currency'] = f"Significant revenue contributions are observed for items '{top_item_x}' and '{top_item_y}', primarily in currencies '{top_currency_x}' and '{top_currency_y}'."



# 4. Revenue and Quantity by Business Unit (BU)
bu_revenue = df.groupby('BU')['Revenue Billed'].sum()
bu_quantity = df.groupby('BU')['Quantity Billed'].sum()

fig, ax1 = plt.subplots(figsize=(15, 16))
ax1.set_xlabel('Business Unit')
ax1.set_ylabel('Revenue Billed', color='tab:blue')
ax1.bar(bu_revenue.index, bu_revenue, color='tab:blue', label='Revenue Billed')
ax1.tick_params(axis='y', labelcolor='tab:blue')
ax1.set_xticklabels(bu_revenue.index, rotation=90)  # Rotate x-axis labels

ax2 = ax1.twinx()
ax2.set_ylabel('Quantity Billed', color='tab:orange')
ax2.plot(bu_quantity.index, bu_quantity, color='tab:orange', label='Quantity Billed', marker='o')
ax2.tick_params(axis='y', labelcolor='tab:orange')

plt.title('Revenue and Quantity by Business Unit')
plt.tight_layout()  # Adjust layout to prevent clipping
image_path_2 = output_dir + 'revenue_quantity_by_bu.png'
plt.savefig(image_path_2, bbox_inches='tight', dpi=80)
plt.close()

# Save image details to the database
save_or_update_image_in_db(user_id, image_path_2, 'Revenue and Quantity by BU')

# Find top business units for revenue and quantity
top_bu_revenue = bu_revenue.idxmax()
top_bu_quantity = bu_quantity.idxmax()

# Add semantic analysis for revenue and quantity by business unit
semantic_analysis['revenue_quantity_by_bu'] = f"The unit '{top_bu_revenue}' generated the highest revenue, while '{top_bu_quantity}' had the highest quantity billed."



# 5. Top Customers by Revenue
top_customers = df.groupby('Customer Name')['Revenue Billed'].sum().nlargest(10)
ax = top_customers.plot(kind='bar', figsize=(10, 26))
plt.title('Top 10 Customers by Revenue')
plt.ylabel('Revenue Billed')
plt.xticks(rotation=90)  # Rotate x-axis labels
plt.tight_layout()  # Adjust layout to prevent clipping
image_path_3 = output_dir + 'top_customers_by_revenue.png'
plt.savefig(image_path_3, bbox_inches='tight', dpi=100)
plt.close()

# Save image details to the database
save_or_update_image_in_db(user_id, image_path_3, 'Top Customers by Revenue')

# Find top customer by revenue
top_customer = top_customers.idxmax()
top_customer_revenue = top_customers.max()
semantic_analysis['top_customers_by_revenue'] = f"'{top_customer}' is the top customer with a total revenue of {top_customer_revenue:.2f}."



# Save semantic analysis to a JSON file
with open(output_dir_json + 'semantic_analysis.json', 'w') as f:
    json.dump(semantic_analysis, f, indent=4)

print("Review analysis images and semantic analysis have been saved.")
