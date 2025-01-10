<?php
// Database connection parameters
$servername = "sql12.freesqldatabase.com";
$username = "sql12756836";
$password = "qEaH9rPgZn";
$database = "sql12756836";

// Get user ID or other identifier from the request (e.g., query parameter)
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : ''; // Ensure to sanitize and validate this input

// Validate user ID
if (empty($user_id)) {
    die("User ID is required.");
}

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query
$sql = "SELECT presentation_path FROM user_presentations WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($presentation_path);

if ($stmt->num_rows > 0) {
    $stmt->fetch();

    // Debug output: Show the presentation path being checked
    echo "Presentation path: " . $presentation_path . "<br>";

    // Check if the file exists
    $full_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $presentation_path;
    if (file_exists($full_path)) {
        header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
        header('Content-Disposition: inline; filename="user1_presentation.pptx"');
        readfile($full_path);
    } else {
        echo "Presentation file does not exist at path: " . $full_path;
    }
} else {
    echo "No presentation found for the user.";
}

$stmt->close();
$conn->close();
?>
