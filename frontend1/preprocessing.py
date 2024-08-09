import pandas as pd
import os

# Step 1: Find the Excel file in the directory
directory_path = 'unclean/'
file_name = [f for f in os.listdir(directory_path) if f.endswith('.xlsx')][0]
file_path = os.path.join(directory_path, file_name)

# Step 2: Load the Excel file
df = pd.read_excel(file_path)

# Step 3: Remove empty columns and rows
df.dropna(how='all', axis=1, inplace=True)  # Remove columns with all NaN values
df.dropna(how='all', axis=0, inplace=True)  # Remove rows with all NaN values

# Step 4: Handle missing values
# We will separate numeric and non-numeric columns for proper handling

# Fill missing values for numeric columns with the median
numeric_cols = df.select_dtypes(include=['number']).columns
df[numeric_cols] = df[numeric_cols].fillna(df[numeric_cols].median())

# Fill missing values for categorical columns with the mode
categorical_cols = df.select_dtypes(include=['object']).columns
for column in categorical_cols:
    df[column].fillna(df[column].mode()[0], inplace=True)

# Step 5: Remove columns with fewer than 5 non-missing values
df = df.loc[:, df.count() >= 5]

# Display the cleaned data
print(df.head())

# Step 6: Save the cleaned data to a new Excel file
output_path = 'uploads/CleanedData.xlsx'
df.to_excel(output_path, index=False)
print(f"Cleaned data saved to {output_path}")
