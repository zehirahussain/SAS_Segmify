<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $username = "NA";; // Redirect to login page if not logged in
    echo "NA"; 
    exit;
}

// Database connection
$servername = "sql12.freesqldatabase.com";
$username = "sql12756836";
$password = "qEaH9rPgZn";
$database = "sql12756836";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's ID from session
$userId = $_SESSION['user_id'];

// Query to check if current_login is set to 1 for the logged-in user
$sql = "SELECT name FROM users WHERE id = ? AND current_login = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user data
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = htmlspecialchars($row['name']);
} else {
    // User is not logged in or current_login is not set to 1
    $username = "NA";
    echo "NA"; 
}

// Close connection
$stmt->close();
$conn->close();

// Output username
echo $username;
