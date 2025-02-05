import pandas as pd
import os
import json

# Adjust the path to your uploads folder
uploads_dir = r"uploads"

# List Excel files in the directory
files = os.listdir(uploads_dir)
excel_files = [file for file in files if file.endswith('.xlsx')]

if not excel_files:
    print(json.dumps({"error": "No Excel file found."}))
    exit()

excel_file_path = os.path.join(uploads_dir, excel_files[0])
df = pd.read_excel(excel_file_path)

if 'Product' not in df.columns:
    print(json.dumps({"error": "Product column not found."}))
    exit()

products = df['Product'].dropna().unique().tolist()
print(json.dumps(products))
