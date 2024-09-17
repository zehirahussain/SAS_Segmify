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

# Function to update PowerPoint presentation with new image
def update_presentation(user_id, image_path):
    conn = get_db_connection()
    cursor = conn.cursor()

    cursor.execute("SELECT presentation_path FROM user_presentations WHERE user_id = %s", (user_id,))
    result = cursor.fetchone()

    # Absolute path for presentations
    ppt_dir = "C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\presentations"
    if not os.path.exists(ppt_dir):
        os.makedirs(ppt_dir)
        
    if result:
        ppt_path = result[0]
    else:
        ppt_path = os.path.join(ppt_dir, f'user{user_id}_presentation.pptx')
        prs = Presentation()
        prs.save(ppt_path)
        cursor.execute(
            "INSERT INTO user_presentations (user_id, presentation_path) VALUES (%s, %s)",
            (user_id, ppt_path)
        )
        conn.commit()

    print(f"Looking for presentation at: {ppt_path}")

    if os.path.exists(ppt_path):
        print(f"Presentation found at {ppt_path}")
    else:
        raise FileNotFoundError(f"Presentation not found at {ppt_path}")

    prs = Presentation(ppt_path)

    # Remove old slides with the same image (if needed)
    for slide in prs.slides:
        for shape in slide.shapes:
            if shape.shape_type == 13 and shape.image.filename == os.path.basename(image_path):
                xml_slides = prs.slides._sldIdLst
                slide_id = slide.slide_id
                slides = list(xml_slides)
                for slide in slides:
                    if slide.id == slide_id:
                        xml_slides.remove(slide)
                        break
                prs.slides._sldIdLst = xml_slides
                break

    # Add a new slide with the image
    slide = prs.slides.add_slide(prs.slide_layouts[5])
    slide.shapes.add_picture(image_path, Inches(1), Inches(1), width=Inches(8), height=Inches(5.5))

    prs.save(ppt_path)

    cursor.close()
    conn.close()

# Directory setup and file checking
uploads_dir = "c:\\xampp\\htdocs\\fyp0.3\\frontend1\\review"

if not os.path.exists(uploads_dir):
    raise FileNotFoundError(f"The directory {uploads_dir} does not exist.")

files = os.listdir(uploads_dir)
print("Files in directory:", files)  # Debug line to see files in the directory

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

# Update PowerPoint presentation with the new image
update_presentation(user_id, plot_path)

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

# Update PowerPoint presentation with the word cloud
update_presentation(user_id, wordcloud_path)

# Read the analysis results from the file
results_file = 'static/analysis_results.json'
with open(results_file, 'r') as file:
    results = json.load(file)

# Use the analysis result for "sentiment_distribution_bar_chart"
analysis_text = results.get('sentiment_distribution_bar_chart', 'No analysis result available.')

# Function to append analysis results to the presentation
def append_analysis_to_presentation(user_id, analysis_text):
    conn = get_db_connection()
    cursor = conn.cursor()

    cursor.execute("SELECT presentation_path FROM user_presentations WHERE user_id = %s", (user_id,))
    result = cursor.fetchone()

    if result:
        ppt_path = result[0]
    else:
        print("Presentation not found.")
        cursor.close()
        conn.close()
        return

    # Debugging print to verify the path
    print(f"Appending analysis to presentation at: {ppt_path}")

    prs = Presentation(ppt_path)
    
    # Add analysis text on a new slide
    analysis_slide = prs.slides.add_slide(prs.slide_layouts[5])
    textbox = analysis_slide.shapes.add_textbox(Inches(1), Inches(1), Inches(8), Inches(5.5))
    text_frame = textbox.text_frame
    p = text_frame.add_paragraph()
    p.text = analysis_text
    p.font.size = Inches(0.2)

    prs.save(ppt_path)
    print(f"Updated presentation with analysis at {ppt_path}")

    cursor.close()
    conn.close()

# Append the analysis results to the presentation
append_analysis_to_presentation(user_id, analysis_text)
