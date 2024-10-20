import json
from PIL import Image, ImageDraw, ImageFont
import os
import textwrap

# Define the image size and text properties
IMAGE_SIZE = (800, 600)
TEXT_COLOR = (0, 0, 0)  # Black text
BACKGROUND_COLOR = (255, 255, 255)  # White background
FONT_SIZE = 40  # 30pt Times New Roman font size
FONT_PATH = "/usr/share/fonts/truetype/dejavu/DejaVuSerif.ttf"  # Adjust this path based on the system

# Function to create an image from text with automatic line wrapping
def create_image_with_text(text, image_name):
    # Create a new image with white background
    img = Image.new('RGB', IMAGE_SIZE, color=BACKGROUND_COLOR)
    draw = ImageDraw.Draw(img)

    # Use Times New Roman font, fallback to default if the font is unavailable
    try:
        font = ImageFont.truetype(FONT_PATH, FONT_SIZE)
    except OSError:
        font = ImageFont.load_default()

    # Set max line width for wrapping text (in pixels)
    max_line_width = IMAGE_SIZE[0] - 600  # 100px padding on both sides

    # Wrap text to fit within the specified width
    wrapped_text = textwrap.fill(text, width=150)

    # Draw each line on the image
    y_offset = 50  # Start drawing text 50px from the top
    lines = wrapped_text.split('\n')
    for line in lines:
        draw.text((50, y_offset), line, font=font, fill=TEXT_COLOR)
        y_offset += FONT_SIZE + 5  # Move to the next line

    # Save the image with `_analysis` suffix
    image_path = os.path.join('static/img/', image_name)
    img.save(image_path)
    print(f"Image saved: {image_path}")

# Load JSON content and generate images based on the data


# Example 2: Process `semantic_analysis.json`.
with open('review/semantic_analysis.json') as f:
    data = json.load(f)
    revenue_by_item_currency_text = data.get('revenue_by_item_currency', 'No analysis available')
    revenue_quantity_by_bu_text = data.get('revenue_quantity_by_bu', 'No analysis available')
    top_customers_by_revenue_text = data.get('top_customers_by_revenue', 'No analysis available')
    
    # Create images for each piece of text with `_analysis` suffix
    create_image_with_text(revenue_by_item_currency_text, "revenue_by_item_currency_analysis.png")
    create_image_with_text(revenue_quantity_by_bu_text, "revenue_quantity_by_bu_analysis.png")
    create_image_with_text(top_customers_by_revenue_text, "top_customers_by_revenue_analysis.png")

# Example 3: Process `static/analysis_results.json`
with open('static/analysis_results.json') as f:
    data = json.load(f)
    
    # Accessing each analysis directly from the JSON
    mrr_by_bu_text = data.get('mrr_by_bu', 'No analysis available')
    revenue_by_product_bar_chart_text = data.get('revenue_by_product_bar_chart', 'No analysis available')
    churn_rate_stacked_bar_chart_text = data.get('churn_rate_stacked_bar_chart', 'No analysis available')
    revenue_by_product_pie_chart_text = data.get('revenue_by_product_pie_chart', 'No analysis available')
    # sentiment_distribution_bar_chart_text = data.get('sentiment_distribution_bar_chart', 'No analysis available')
    
    # Create images for each analysis text with `_analysis` suffix
    create_image_with_text(mrr_by_bu_text, "mrr_by_bu_analysis.png")
    create_image_with_text(revenue_by_product_bar_chart_text, "revenue_by_product_bar_chart_analysis.png")
    create_image_with_text(churn_rate_stacked_bar_chart_text, "churn_rate_stacked_bar_chart_analysis.png")
    create_image_with_text(revenue_by_product_pie_chart_text, "revenue_by_product_pie_chart_analysis.png")
    # create_image_with_text(sentiment_distribution_bar_chart_text, "sentiment_distribution_bar_chart_analysis.png")


with open('review/review_analysis_results.json') as f:
    data = json.load(f)
    sentiment_distribution_bar_chart_text = data.get('sentiment_distribution_bar_chart', 'No analysis available')
    
    # Create images for each analysis text with `_analysis` suffix
  
    create_image_with_text(sentiment_distribution_bar_chart_text, "sentiment_distribution_bar_chart_analysis.png")