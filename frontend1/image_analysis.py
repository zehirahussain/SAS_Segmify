import os
import json
import google.generativeai as genai
import time
from google.api_core import exceptions
import re

# Configure API key
genai.configure(api_key='KEY')

def clean_text(text):
    # Remove extra whitespace and normalize line breaks
    text = ' '.join(text.split())
    # Remove any special characters that might cause formatting issues
    text = re.sub(r'[^\w\s.,!?()-]', '', text)
    # Ensure proper spacing after punctuation
    text = re.sub(r'([.,!?()])', r'\1 ', text)
    # Remove any double spaces that might have been created
    text = re.sub(r'\s+', ' ', text)
    return text.strip()

def upload_image(file_path, display_name):
    try:
        sample_file = genai.upload_file(path=file_path, display_name=display_name)
        return sample_file
    except Exception as e:
        print(f"Error uploading file {file_path}: {e}")
        return None

def analyze_images(image_paths, prompt):
    model = genai.GenerativeModel(model_name="gemini-1.5-flash")
    results = []
    
    for path in image_paths:
        max_retries = 3
        retry_count = 0
        
        while retry_count < max_retries:
            try:
                uploaded_image = upload_image(path, os.path.basename(path))
                if uploaded_image is None:
                    break
                
                response = model.generate_content([uploaded_image, prompt])
                cleaned_text = clean_text(response.text)
                results.append(cleaned_text)
                time.sleep(2)  # Wait between successful requests
                break  # Break the retry loop if successful
                
            except exceptions.ResourceExhausted as e:
                print(f"Rate limit reached for {path}: {e}")
                time.sleep(10)  # Wait longer when rate limited
                retry_count += 1
                
            except exceptions.InternalServerError as e:
                print(f"Internal server error for {path}: {e}")
                time.sleep(5)
                retry_count += 1
                
            except Exception as e:
                print(f"Unexpected error processing {path}: {e}")
                results.append(f"Error analyzing image: {str(e)}")
                break
        
        if retry_count == max_retries:
            results.append(f"Failed to analyze image after {max_retries} attempts: {path}")
            
    return results

# Image paths
image_paths = [
    'static/images/mrr_by_bu.png',
    'static/images/revenue_by_product_bar_chart.png',
    'static/images/churn_rate_stacked_bar_chart.png',
    'static/images/revenue_by_product_pie_chart.png',
    'static/images/sentiment_distribution_bar_chart.png'
]

# Example prompt
prompt = "Explain the image in short with value."

try:
    # Analyze images
    print("Starting image analysis...")
    results = analyze_images(image_paths, prompt)
    
    # Save results to a file with cleaned text
    results_file = 'static/analysis_results.json'
    with open(results_file, 'w', encoding='utf-8') as file:
        cleaned_results = {
            'mrr_by_bu': results[0] if len(results) > 0 else "Analysis failed",
            'revenue_by_product_bar_chart': results[1] if len(results) > 1 else "Analysis failed",
            'churn_rate_stacked_bar_chart': results[2] if len(results) > 2 else "Analysis failed",
            'revenue_by_product_pie_chart': results[3] if len(results) > 3 else "Analysis failed",
            'sentiment_distribution_bar_chart': results[4] if len(results) > 4 else "Analysis failed"
        }
        json.dump(cleaned_results, file, indent=4, ensure_ascii=False)
    
    print("Analysis completed and results saved to:", results_file)

except Exception as e:
    print(f"Fatal error in main execution: {e}")