<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $target_dir = "uploads/";
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
  if ($_FILES["file"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Upload file
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        // Redirect to the main page to refresh
        header("Location: segmentationandrevenue.html"); // Adjust to your main page
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
  }
} else {
  echo "Invalid request.";
}
?>

