import pandas as pd
import matplotlib.pyplot as plt
from fpdf import FPDF
import os

# Create a PDF class
class PDF(FPDF):
    def header(self):
        self.set_font('Helvetica', 'B', 12)
        self.cell(0, 10, 'Monthly Report', new_x='LMARGIN', new_y='NEXT', align='C')

    def footer(self):
        self.set_y(-15)
        self.set_font('Helvetica', 'I', 8)
        self.cell(0, 10, f'Page {self.page_no()}', new_x='RIGHT', new_y='TOP', align='C')

pdf = PDF()
pdf.add_page()

# Read the dataset from Excel
uploads_dir = "uploads"

# List all files in the uploads directory
files = os.listdir(uploads_dir)

# Identify the Excel file (assuming there is only one Excel file in the directory)
excel_files = [file for file in files if file.endswith('.xlsx')]

# Check if there is at least one Excel file
if not excel_files:
    raise FileNotFoundError("No Excel file found in the uploads directory.")

# Read the first Excel file found
excel_file_path = os.path.join(uploads_dir, excel_files[0])
df = pd.read_excel(excel_file_path)

# Section 1: Revenue by Product
revenue_by_product = df.groupby('Product')['Revenue Billed'].sum().reset_index()
plt.figure(figsize=(10, 8))
plt.pie(revenue_by_product['Revenue Billed'], labels=revenue_by_product['Product'], autopct='%1.1f%%', startangle=140, colors=plt.cm.Paired(range(len(revenue_by_product))))
plt.title('Revenue Billed by Product', fontsize=16)
plt.axis('equal')

output_dir = os.path.join('static', 'images')
os.makedirs(output_dir, exist_ok=True)
chart1_path = os.path.join(output_dir, 'chart1.png')
plt.savefig(chart1_path)
pdf.image(chart1_path, x=10, y=20, w=190)
plt.close()

pdf.add_page()

# Section 2: Monthly Recurring Revenue (MRR)
df['Invoice Date'] = pd.to_datetime(df['Invoice Date'])
df['Month'] = df['Invoice Date'].dt.to_period('M')
mrr = df.groupby('Month')['Revenue Billed'].sum().reset_index()
plt.figure(figsize=(12, 8))
plt.plot(mrr['Month'].astype(str), mrr['Revenue Billed'], marker='o', linestyle='-', color='b')
plt.xlabel('Month', fontsize=14)
plt.ylabel('Monthly Recurring Revenue', fontsize=14)
plt.title('Monthly Recurring Revenue (MRR)', fontsize=16)
plt.grid(True)
plt.xticks(rotation=45)

chart2_path = os.path.join(output_dir, 'chart2.png')
plt.savefig(chart2_path)
pdf.image(chart2_path, x=10, y=20, w=190)
plt.close()

pdf.add_page()

# Section 3: Customer Segmentation using RFM Analysis
# Use 'Customer Original' for customer segmentation
if 'Customer Original' in df.columns:
    rfm = df.groupby('Customer Original').agg({
        'Invoice Date': lambda x: (pd.Timestamp.today() - x.max()).days,
        'Revenue Billed': ['sum', 'count']
    }).reset_index()
    rfm.columns = ['Customer Original', 'Recency', 'Monetary', 'Frequency']

    # Normalize the RFM metrics
    rfm['Recency'] = pd.qcut(rfm['Recency'], 4, labels=range(4, 0, -1))
    rfm['Frequency'] = pd.qcut(rfm['Frequency'].rank(method='first'), 4, labels=range(1, 5))
    rfm['Monetary'] = pd.qcut(rfm['Monetary'], 4, labels=range(1, 5))

    rfm['RFM_Score'] = rfm[['Recency', 'Frequency', 'Monetary']].sum(axis=1)

    segments = {
        r'[1-2][1-2]': 'Low-Value',
        r'[1-2][3-4]': 'Mid-Value',
        r'[3-4][1-2]': 'Mid-Value',
        r'[3-4][3-4]': 'High-Value'
    }

    rfm['Segment'] = rfm['RFM_Score'].apply(lambda x: 'High-Value' if x > 9 else 'Mid-Value' if x > 5 else 'Low-Value')
    segment_counts = rfm['Segment'].value_counts()

    plt.figure(figsize=(10, 8))
    plt.pie(segment_counts, labels=segment_counts.index, autopct='%1.1f%%', startangle=140, colors=plt.cm.Paired(range(len(segment_counts))))
    plt.title('Customer Segmentation', fontsize=16)
    plt.axis('equal')

    chart3_path = os.path.join(output_dir, 'chart3.png')
    plt.savefig(chart3_path)
    pdf.image(chart3_path, x=10, y=20, w=190)
    plt.close()
else:
    pdf.set_font('Helvetica', 'I', 12)
    pdf.cell(0, 10, 'Customer Original column not found in the dataset.', ln=True, align='C')

pdf.add_page()

# Section 4: Customer Review Analysis (assuming df_reviews contains the necessary data)
#df_reviews = pd.read_excel("SampleData (2).xlsx", sheet_name='Reviews')

# Word cloud generation code here (assuming you've generated a word cloud image named wordcloud.png)

#wordcloud_path = os.path.join(output_dir, 'wordcloud.png')
#if os.path.exists(wordcloud_path):
 #   pdf.image(wordcloud_path, x=10, y=20, w=190)
#else:
 #   pdf.set_font('Helvetica', 'I', 12)
  #  pdf.cell(0, 10, 'Word cloud image not found.', ln=True, align='C')

# Save PDF
output_pdf_dir = os.path.join('static', 'reports')
os.makedirs(output_pdf_dir, exist_ok=True)
pdf_output_path = os.path.join(output_pdf_dir, 'monthly_report.pdf')
pdf.output(pdf_output_path)

print(f"PDF report saved to {pdf_output_path}")
