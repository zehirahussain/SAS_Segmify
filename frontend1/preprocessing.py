import pandas as pd
from imblearn.over_sampling import SMOTE
import os
from sklearn.preprocessing import LabelEncoder

# Initialize progress tracking file
progress_file = 'preprocessing_progress.txt'

# Helper function to update progress
def update_progress(value):
    with open(progress_file, 'w') as f:
        f.write(str(value))

# Step 1: Find the Excel file in the directory
directory_path = 'unclean/'  # Change this to your actual directory path
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
# Fill missing values for numeric columns with the median
numeric_cols = df.select_dtypes(include=['number']).columns
df[numeric_cols] = df[numeric_cols].fillna(df[numeric_cols].median())

# Fill missing values for categorical columns with the mode
categorical_cols = df.select_dtypes(include=['object']).columns
for column in categorical_cols:
    df[column] = df[column].fillna(df[column].mode()[0])  # Avoid chained assignment warning

update_progress(60)

# Step 5: Remove columns with fewer than 5 non-missing values
df = df.loc[:, df.count() >= 5]
update_progress(80)

# Step 6: Convert all values in categorical columns to strings
for column in categorical_cols:
    df[column] = df[column].astype(str)

# Step 7: Encode categorical features and store mapping for later decoding
label_encoders = {}
encoded_dfs = df.copy()  # Keep a copy for decoding later
for column in categorical_cols:
    le = LabelEncoder()
    encoded_dfs[column] = le.fit_transform(df[column])
    label_encoders[column] = le  # Store encoder for later decoding

# Step 8: Convert DateTime columns to numerical values
datetime_cols = df.select_dtypes(include=['datetime']).columns
for column in datetime_cols:
    encoded_dfs[column] = df[column].astype('int64')  # Convert DateTime to int64

# Step 9: Handle imbalanced data using SMOTE
target_column = 'Rating'  # Replace 'Rating' with the actual target column
if target_column not in df.columns:
    raise KeyError(f"'{target_column}' not found in DataFrame columns. Available columns: {df.columns}")

# Convert target column to discrete classes (bins)
encoded_dfs[target_column] = pd.cut(df[target_column], bins=3, labels=[0, 1, 2])  # Adjust bins and labels as needed

# Separate features (X) and target (y)
X = encoded_dfs.drop(target_column, axis=1)
y = encoded_dfs[target_column]

# Apply SMOTE to balance the dataset
smote = SMOTE(random_state=42)
X_resampled, y_resampled = smote.fit_resample(X, y)

# Create DataFrame for the balanced data
balanced_df = pd.concat([pd.DataFrame(X_resampled, columns=X.columns), pd.DataFrame(y_resampled, columns=[target_column])], axis=1)
update_progress(90)  # 90% progress

# ---- Reverse Encoding (Decode categorical variables) ---- #
decoded_df = balanced_df.copy()
for column in categorical_cols:
    if column in label_encoders:
        decoded_df[column] = label_encoders[column].inverse_transform(balanced_df[column])

# Save the **final version** with original categorical values
final_output_path = 'uploads/CleanedData.xlsx'
decoded_df.to_excel(final_output_path, index=False)

update_progress(100)  # Processing complete

# Indicate processing is done
with open(progress_file, 'w') as f:
    f.write('done')

print("Preprocessing and balancing completed successfully!")

