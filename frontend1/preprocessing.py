
import pandas as pd
import os

# Initialize progress tracking file
progress_file = 'preprocessing_progress.txt'

# Helper function to update progress
def update_progress(value):
    with open(progress_file, 'w') as f:
        f.write(str(value))

# Step 1: Find the Excel file in the directory
directory_path = 'unclean/'
file_name = [f for f in os.listdir(directory_path) if f.endswith('.xlsx')][0]
file_path = os.path.join(directory_path, file_name)

# Step 2: Load the Excel file
df = pd.read_excel(file_path)
update_progress(20)  # 20% progress after loading

# Step 3: Remove empty columns and rows
df.dropna(how='all', axis=1, inplace=True)  # Remove columns with all NaN values
df.dropna(how='all', axis=0, inplace=True)  # Remove rows with all NaN values
update_progress(40)

# Step 4: Handle missing values
numeric_cols = df.select_dtypes(include=['number']).columns
df[numeric_cols] = df[numeric_cols].fillna(df[numeric_cols].median())
categorical_cols = df.select_dtypes(include=['object']).columns
for column in categorical_cols:
    df[column].fillna(df[column].mode()[0], inplace=True)
update_progress(60)

# Step 5: Remove columns with fewer than 5 non-missing values
df = df.loc[:, df.count() >= 5]
update_progress(80)

# Step 6: Save the cleaned data to a new Excel file
output_path = 'uploads/CleanedData.xlsx'
df.to_excel(output_path, index=False)
update_progress(100)

# Indicate processing is done
with open(progress_file, 'w') as f:
    f.write('done')
