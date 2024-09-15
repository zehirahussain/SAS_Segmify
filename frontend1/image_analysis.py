import os
import json
import google.generativeai as genai

# Configure API key
genai.configure(api_key='KEY')

def upload_image(file_path, display_name):
    sample_file = genai.upload_file(path=file_path, display_name=display_name)
    return sample_file

def analyze_images(image_paths, prompt):
    model = genai.GenerativeModel(model_name="gemini-1.5-pro")
    results = []
    for path in image_paths:
        file = upload_image(path, os.path.basename(path))
        response = model.generate_content([file,"Describe the image."])
        results.append(response.text.strip())
    return results

# Image paths
image_paths = [
    'static/images/mrr_by_bu.png',
    'static/images/revenue_by_product_bar_chart.png',
    'static/images/churn_rate_stacked_bar_chart.png',
    'static/images/revenue_by_product_pie_chart.png',
    'static/images/sentiment_distribution_bar_chart'
]

# Example prompt
prompt = "Describe the image."

# Analyze images
results = analyze_images(image_paths, prompt)

# Print results as a single JSON string
print(json.dumps(results))

# Save results to a file
results_file = 'static/analysis_results.json'
with open(results_file, 'w') as file:
    json.dump({
        'mrr_by_bu': results[0],
        'revenue_by_product_bar_chart': results[1],
        'churn_rate_stacked_bar_chart': results[2],
        'revenue_by_product_pie_chart': results[3],
        'sentiment_distribution_bar_chart' : results[4]
    }, file, indent=5)
