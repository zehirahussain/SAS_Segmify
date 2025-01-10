<?php
// Start session
session_start();

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

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Update the current_login status in the database
    $updateLoginStatus = "UPDATE users SET current_login = FALSE WHERE id = $userId";
    $conn->query($updateLoginStatus);

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();
}

// Close connection
$conn->close();

// Redirect to the login page or home page
header('Location: index.php');
exit;

