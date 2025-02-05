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
import sys
#download_corpora()

# Database connection function
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

# Set the uploads directory
uploads_dir = r"uploads"
if not os.path.exists(uploads_dir):
    raise FileNotFoundError(f"The directory {uploads_dir} does not exist.")

files = os.listdir(uploads_dir)
excel_files = [file for file in files if file.endswith('.xlsx')]

if not excel_files:
    raise FileNotFoundError("No Excel file found in the review directory.")

excel_file_path = os.path.join(uploads_dir, excel_files[0])
df = pd.read_excel(excel_file_path)

# If the Excel file has a Product column and a product filter is given, filter the DataFrame.
product_filter = None
if len(sys.argv) > 1:
    product_filter = sys.argv[1]

if product_filter and 'Product' in df.columns:
    df = df[df['Product'] == product_filter]

# Filter relevant columns (assuming Comments and Rating exist)
relevant_cols = ["Comments", "Rating"]
df = df[relevant_cols]

df['Comments'] = df['Comments'].fillna('')

def get_sentiment(text):
    if not isinstance(text, str):
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

sentiment_counts = df['Sentiment'].value_counts()
plt.figure(figsize=(10, 8), facecolor='white')
plt.bar(sentiment_counts.index, sentiment_counts.values, color='skyblue')
plt.xlabel("Sentiment", fontsize=10, color='black')
plt.ylabel("Count", fontsize=10, color='black')
plt.title("Sentiment Distribution", fontsize=12, color='black')
plt.xticks(fontsize=10, color='black')
plt.yticks(fontsize=10, color='black')
plt.gca().set_facecolor('white')
for spine in plt.gca().spines.values():
    spine.set_color('black')
plt.tight_layout()

output_dir = r"C:\xampp\htdocs\fyp0.3\frontend1\static\images"
if not os.path.exists(output_dir):
    os.makedirs(output_dir)
plot_path = os.path.join(output_dir, 'sentiment_distribution_bar_chart.png')
plt.savefig(plot_path, facecolor='white')
plt.close()

# Save image details to the database (using a dummy user_id for now)
user_id = 1  
image_type = "Sentiment Distribution"
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

