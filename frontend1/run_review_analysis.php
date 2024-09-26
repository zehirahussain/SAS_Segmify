<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$command = 'python review_analysis.py';
$output = shell_exec($command);
// Path to the Python script


// Check for errors in the output
if ($output === null) {
    echo json_encode(['status' => 'error', 'message' => 'Error executing the Python script.']);
    exit();
}

// Return success status
echo json_encode(['status' => 'success']);