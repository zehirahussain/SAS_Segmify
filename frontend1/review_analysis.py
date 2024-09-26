import pandas as pd
import matplotlib.pyplot as plt
import os
import mysql.connector
from pptx import Presentation
from pptx.util import Inches
import json
from textblob import TextBlob
from wordcloud import WordCloud
import seaborn as sns
from textblob import download_corpora
#download_corpora()

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




#uploads_dir = "review"
uploads_dir = "c:\\xampp\\htdocs\\fyp0.3\\frontend1\\review"

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

# Filter relevant columns
relevant_cols = ["Comments", "Rating"]
df = df[relevant_cols]

# Handle missing or NaN values in 'Comments'
df['Comments'] = df['Comments'].fillna('')

# Sentiment Analysis
def get_sentiment(text):
    if not isinstance(text, str):  # Ensure text is a string
        text = str(text)
    analysis = TextBlob(text)
    polarity = analysis.sentiment.polarity
    if polarity > 0:
        return 'positive'
    elif polarity < 0:
        return 'negative'
    else:
        return 'neutral'

df['Sentiment'] = df['Comments'].apply(get_sentiment)

# Generate sentiment distribution plot
sentiment_counts = df['Sentiment'].value_counts()
plt.figure(figsize=(10, 8), facecolor='white')
plt.bar(sentiment_counts.index, sentiment_counts.values, color='skyblue')
plt.xlabel("Sentiment", fontsize=10, color='black')
plt.ylabel("Count", fontsize=10, color='black')
plt.title("Sentiment Distribution", fontsize=12, color='black')
plt.xticks(fontsize=10, color='black')
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
plot_path = os.path.join(output_dir, 'sentiment_distribution_bar_chart.png')
plt.savefig(plot_path, facecolor='white')
plt.close()

# Define user ID and image type
user_id = 1  # Replace with actual user ID
image_type = "Sentiment Distribution"

# Save image details to the database
save_or_update_image_in_db(user_id, plot_path, image_type)



# Generate word cloud from reviews
text = " ".join(review for review in df['Comments'])
wordcloud = WordCloud(width=800, height=400, background_color='white').generate(text)

plt.figure(figsize=(10, 6))
plt.imshow(wordcloud, interpolation='bilinear')
plt.axis('off')
wordcloud_path = os.path.join(output_dir, 'wordcloud.png')
plt.savefig(wordcloud_path, facecolor='white')
plt.close()

# Save word cloud image details to the database
image_type = "Word Cloud"
save_or_update_image_in_db(user_id, wordcloud_path, image_type)

