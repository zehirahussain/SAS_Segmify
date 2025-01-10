<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "unclean/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a valid .xlsx file
    if ($fileType != "xlsx") {
        echo json_encode(['success' => false, 'message' => 'Sorry, only .xlsx files are allowed.']);
        $uploadOk = 0;
    }

    // Check if file already exists


    // Check file size
    if ($_FILES["file"]["size"] > 50000000) { // 50MB limit
        echo json_encode(['success' => false, 'message' => 'Sorry, your file is too large.']);
        $uploadOk = 0;
    }

    // Upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

            // Start preprocessing in the background
            exec('python preprocessing.py > /dev/null 2>/dev/null &');

            // Return response immediately, preprocessing will continue in the background
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sorry, there was an error uploading your file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Sorry, your file was not uploaded.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}