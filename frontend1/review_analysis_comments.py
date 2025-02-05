import pandas as pd
import json
from textblob import TextBlob
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from sumy.parsers.plaintext import PlaintextParser
from sumy.nlp.tokenizers import Tokenizer
from sumy.summarizers.lsa import LsaSummarizer
import matplotlib.pyplot as plt
import re
import os
import sys

# Set the uploads directory (adjust as needed)
uploads_dir = "uploads"
if not os.path.exists(uploads_dir):
    raise FileNotFoundError(f"The directory {uploads_dir} does not exist.")

files = os.listdir(uploads_dir)
excel_files = [file for file in files if file.endswith('.xlsx')]

if not excel_files:
    raise FileNotFoundError("No Excel file found in the review directory.")

excel_file_path = os.path.join(uploads_dir, excel_files[0])
data = pd.read_excel(excel_file_path)

# Determine which product to analyze.
# If a product name is passed as an argument, use it. Otherwise, use the default (most revenue-generating).
if len(sys.argv) > 1:
    selected_product = sys.argv[1]
else:
    selected_product = data.groupby('Product')['Revenue Billed'].sum().idxmax()

# Optionally, check if the selected product exists:
if selected_product not in data['Product'].unique():
    # Fallback to default if not found.
    selected_product = data.groupby('Product')['Revenue Billed'].sum().idxmax()

def collect_reviews(product_or_item):
    reviews = data[data['Product'] == product_or_item]['Comments'].tolist()
    # Use at most 10 comments (or more if you wish)
    sampled_reviews = reviews[:10]
    return ' '.join(sampled_reviews)

def preprocess_text(text):
    tokens = word_tokenize(text)
    stop_words = set(stopwords.words('english'))
    filtered_tokens = [word for word in tokens if word.lower() not in stop_words]
    return ' '.join(filtered_tokens)

def capitalize_sentences(text):
    sentences = re.split(r'(?<!\w\.\w.)(?<![A-Z][a-z]\.)(?<=\.|\?)\s', text)
    sentences = [s.capitalize() for s in sentences if s]
    return ' '.join(sentences)

def format_paragraph(text):
    text = re.sub(r'\s+([?.!,"](?:\s|$))', r'\1', text)
    text = text.replace(" .", ".")
    return text.strip()

def analyze_condition(condition_name, identifier, reviews_text):
    preprocessed_text = preprocess_text(reviews_text)
    parser = PlaintextParser.from_string(preprocessed_text, Tokenizer("english"))
    summarizer = LsaSummarizer()
    summary_sentences = summarizer(parser.document, 3)  # Adjust number of sentences if needed
    summary = ' '.join(str(sentence) for sentence in summary_sentences)
    cleaned_summary = capitalize_sentences(summary)
    paragraph = format_paragraph(cleaned_summary)
    sentiment_analysis = TextBlob(paragraph).sentiment

    analysis = {
        "summary": paragraph,
        "sentiment_polarity": sentiment_analysis.polarity,
        "sentiment_subjectivity": sentiment_analysis.subjectivity,
    }
    return {
        'condition': condition_name,
        'identifier': identifier,
        'analysis': analysis
    }

def generate_sentiment_graph(text):
    analysis = TextBlob(text).sentiment
    polarity = analysis.polarity
    subjectivity = analysis.subjectivity

    plt.figure(figsize=(8, 6))
    plt.bar(['Polarity', 'Subjectivity'], [polarity, subjectivity], color=['blue', 'orange'])
    plt.xlabel('Sentiment Aspects')
    plt.ylabel('Scores')
    plt.title('Sentiment Polarity and Subjectivity')
    plt.ylim([-1, 1])
    plt.grid(True)
    plt.savefig('static/images/sentiment_polarity_graph.png')
    plt.close()

results = {
    'most_revenue_product': analyze_condition('Selected Product', selected_product, collect_reviews(selected_product))
}

# Write the semantic analysis results to JSON.
with open('review/review_analysis_results.json', 'w', encoding='utf-8') as f:
    json.dump(results, f, indent=4, ensure_ascii=False)

# Generate the sentiment polarity graph
generate_sentiment_graph(results['most_revenue_product']['analysis']['summary'])

print("Review analysis results have been saved to review/review_analysis_results.json")
print("Sentiment polarity graph has been saved to static/images/sentiment_polarity_graph.png")
