<?php
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
        echo "Sorry, only .xlsx files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 50000000) { // 50MB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            
            // Run the Python preprocessing script
            $output = shell_exec('python preprocessing.py'); // Use python3 if applicable

            // Check if the preprocessing was successful
            if ($output === null) {
                echo "Sorry, there was an error in preprocessing the file.";
            } else {
                // Redirect to the main page after successful processing
                header("Location: segmentationandrevenue.html"); // Adjust to your main page
                exit();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, your file was not uploaded.";
    }
} else {
    echo "Invalid request.";
}
?>
