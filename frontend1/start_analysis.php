<?php
// start_analysis.php

// Execute the Python script and capture its output
$command = 'python image_analysis.py';
$output = shell_exec($command);

// Decode the JSON output
$analysis_results = json_decode($output, true);

// Return the result
echo json_encode(['status' => 'success', 'results' => $analysis_results]);
