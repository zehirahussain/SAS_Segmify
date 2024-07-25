from fpdf import FPDF
import os

class PDF(FPDF):
    def header(self):
        self.set_font('Helvetica', 'B', 12)  # Updated to Helvetica
        self.cell(0, 10, 'Monthly Report', new_x='LMARGIN', new_y='TOP', align='C')  # Updated parameters

    def footer(self):
        self.set_y(-15)
        self.set_font('Helvetica', 'I', 8)  # Updated to Helvetica
        self.cell(0, 10, f'Page {self.page_no()}', new_x='RIGHT', new_y='TOP', align='C')  # Updated parameters

def generate_pdf(filename):
    pdf = PDF()
    pdf.add_page()
    pdf.set_font("Helvetica", size=12)  # Updated to Helvetica
    
    # Directory containing images
    images_dir = 'static/images'
    
    # List all image files
    images = [f for f in os.listdir(images_dir) if os.path.isfile(os.path.join(images_dir, f))]
    
    for image in images:
        # Add each image to the PDF
        image_path = os.path.join(images_dir, image)
        pdf.add_page()
        pdf.image(image_path, x=10, y=10, w=180)  # Adjust x, y, w as needed
    
    # Save the PDF to the static/reports directory
    output_path = os.path.join("static", "reports", filename)
    pdf.output(output_path)
    return output_path

generate_pdf("monthly_report.pdf")
output_dir = os.path.join('C:\\xampp\\htdocs\\fyp0.3\\frontend1\\static\\reports')
if not os.path.exists(output_dir):
    os.makedirs(output_dir)
plot_path = os.path.join(output_dir, 'monthly_report.pdf')


print(f'monthly report saved to {plot_path}')
