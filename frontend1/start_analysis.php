<?php
// start_analysis.php

// Execute the Python script (no need to capture output here)
$command = 'python image_analysis.py';
shell_exec($command); 

// Path to your JSON file
$resultsFile = 'static/analysis_results.json';

// Check if the file exists
if (file_exists($resultsFile)) {
    // Read the JSON data from the file
    $jsonData = file_get_contents($resultsFile);

    // Decode the JSON data into an array
    $results = json_decode($jsonData, true);

    // Return the result with success status
    echo json_encode(['status' => 'success', 'results' => $results]);
} else {
    // If the file doesn't exist, return an error status
    echo json_encode(['status' => 'error', 'message' => 'Analysis results file not found']);
}
?>