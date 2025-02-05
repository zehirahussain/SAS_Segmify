<?php
header('Content-Type: application/json');

if (!isset($_GET['product']) || empty($_GET['product'])) {
    http_response_code(400);
    echo json_encode(["error" => "Product parameter is missing."]);
    exit;
}

$product = $_GET['product'];

// Run the sentiment distribution chart generation script with the product filter.
$command1 = escapeshellcmd("python review_analysis.py " . escapeshellarg($product));
$output1 = shell_exec($command1);

// Run the review analysis (semantic analysis) script with the product filter.
$command2 = escapeshellcmd("python review_analysis_comments.py " . escapeshellarg($product));
$output2 = shell_exec($command2);

// Read the updated JSON file (produced by review_analysis_comments.py)
$jsonFile = 'review/review_analysis_results.json';
if (!file_exists($jsonFile)) {
    http_response_code(500);
    echo json_encode(["error" => "JSON results file not found."]);
    exit;
}

$jsonData = file_get_contents($jsonFile);
$analysisData = json_decode($jsonData, true);

// Prepare the response. (Assuming the sentiment distribution image is always saved as the same name.)
$response = [
    "chart_url" => "static/images/sentiment_distribution_bar_chart.png?" . time(), // Append timestamp to prevent caching
    "analysis"  => $analysisData['most_revenue_product']
];

echo json_encode($response);
?>
