import pandas as pd
import json
from textblob import TextBlob
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk.stem import PorterStemmer
from sumy.parsers.plaintext import PlaintextParser
from sumy.nlp.tokenizers import Tokenizer
from sumy.summarizers.lsa import LsaSummarizer
import matplotlib.pyplot as plt
import re
import os

# Load your review data
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
data = pd.read_excel(excel_file_path)
# data = pd.read_excel('uploads/SampleData (2).xlsx')

# Identify key products/items
most_revenue_product = data.groupby('Product')['Revenue Billed'].sum().idxmax()

# Collect reviews/comments (adjust column names as needed)
def collect_reviews(product_or_item):
    reviews = data[data['Product'] == product_or_item]['Comments'].tolist()
    # Sample at least 10 comments
    sampled_reviews = reviews[:10]  # Ensure there are at least 10 comments
    return ' '.join(sampled_reviews)

# Preprocess text for summarization
def preprocess_text(text):
    # Tokenize
    tokens = word_tokenize(text)
    # Remove stop words
    stop_words = set(stopwords.words('english'))
    filtered_tokens = [word for word in tokens if word.lower() not in stop_words]
    # Join tokens back into a string
    return ' '.join(filtered_tokens)

# Function to capitalize the first letter of each sentence
def capitalize_sentences(text):
    sentences = re.split(r'(?<!\w\.\w.)(?<![A-Z][a-z]\.)(?<=\.|\?)\s', text)  # Split by sentence
    sentences = [s.capitalize() for s in sentences if s]  # Capitalize and filter out empty strings
    return ' '.join(sentences)

# Function to format the summary into a complete paragraph
def format_paragraph(text):
    # Ensure sentences are well-structured
    text = re.sub(r'\s+([?.!,"](?:\s|$))', r'\1', text)  # Remove spaces before punctuation
    text = text.replace(" .", ".")  # Fix spaces before periods
    return text.strip()

# Analyze and summarize reviews using sumy for summarization
def analyze_condition(condition_name, identifier, reviews_text):
    # Preprocess text
    preprocessed_text = preprocess_text(reviews_text)

    # Summarize
    parser = PlaintextParser.from_string(preprocessed_text, Tokenizer("english"))
    summarizer = LsaSummarizer()
    summary_sentences = summarizer(parser.document, 3)  # Adjust number of sentences as needed
    summary = ' '.join(str(sentence) for sentence in summary_sentences)

    # Capitalize and clean up the summary
    cleaned_summary = capitalize_sentences(summary)
    paragraph = format_paragraph(cleaned_summary)

    # Get sentiment analysis
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

# Generate sentiment polarity graph
def generate_sentiment_graph(text):
    analysis = TextBlob(text).sentiment
    polarity = analysis.polarity
    subjectivity = analysis.subjectivity

    plt.figure(figsize=(8, 6))
    plt.bar(['Polarity', 'Subjectivity'], [polarity, subjectivity], color=['blue', 'orange'])
    plt.xlabel('Sentiment Aspects')
    plt.ylabel('Scores')
    plt.title('Sentiment Polarity and Subjectivity')
    plt.ylim([-1, 1])  # Sentiment scores range from -1 to 1
    plt.grid(True)

    # Save the plot
    plt.savefig('static/images/sentiment_polarity_graph.png')
    plt.close()

# Generate JSON output with sentiment analysis and summaries
results = {
    'most_revenue_product': analyze_condition('Most Revenue-Generating Product', most_revenue_product, collect_reviews(most_revenue_product))
}

with open('review/review_analysis_results.json', 'w', encoding='utf-8') as f:
    json.dump(results, f, indent=4, ensure_ascii=False)  # Ensure proper encoding

# Generate sentiment polarity graph
generate_sentiment_graph(results['most_revenue_product']['analysis']['summary'])

print("Review analysis results have been saved to review/review_analysis_results.json")
print("Sentiment polarity graph has been saved to images/sentiment_polarity_graph.png")
