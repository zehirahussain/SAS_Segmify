from django.shortcuts import render

# Create your views here.
import pandas as pd
import matplotlib.pyplot as plt
from django.shortcuts import render
import os

def generate_plot():
    # Read the dataset from Excel
    df = pd.read_excel("SampleData (2).xlsx")

    # Filter relevant columns
    relevant_cols = ["BU", "Revenue Billed", "Currency", "Quantity Billed", "SB FX Rate", "Sales Tax Billed", "Recog. Months"]
    df = df[relevant_cols]

    # Aggregate MRR by Business Unit
    mrr_by_bu = df.groupby("BU")["Revenue Billed"].sum().reset_index()

    # Bar chart
    plt.figure(figsize=(12, 8))
    plt.bar(mrr_by_bu["BU"], mrr_by_bu["Revenue Billed"])
    plt.xlabel("Business Unit", fontsize=14)
    plt.ylabel("Monthly Recurring Revenue (MRR)", fontsize=14)
    plt.title("Monthly Recurring Revenue by Business Unit", fontsize=16)
    plt.xticks(rotation=45, ha="right", fontsize=12)
    plt.tight_layout()

    # Save the plot as a static image
    plot_path = os.path.join('static', 'images', 'mrr_by_bu.png')
    plt.savefig(plot_path)
    plt.close()
    return plot_path

def home(request):
    plot_path = generate_plot()
    return render(request, 'frontend1/segmentationandrevenue.html', {'plot_path': plot_path})
