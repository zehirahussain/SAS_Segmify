<?php
session_start();
$servername = "sql12.freesqldatabase.com";
$username = "sql12756836";
$password = "qEaH9rPgZn";
$database = "sql12756836";

// Check if user is not logged in 
if (!isset($_SESSION['email'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email from query parameter
$emailToDelete = isset($_GET['email']) ? $_GET['email'] : '';

// Security Check: Ensure the email to delete matches the logged-in user's email
if ($emailToDelete !== $_SESSION['email']) {
  echo "Unauthorized deletion attempt!";
  exit(); 
} 

// Prepare and execute SQL query to delete the user
$stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
$stmt->bind_param("s", $emailToDelete); 

if ($stmt->execute()) {
    // Account deleted successfully
    session_unset();
    session_destroy();
    echo "Account deleted successfully!";
    header("Location: index.php"); 
    exit();
} else {
    echo "Error deleting the account: " . $stmt->error;
}

// Close database connection
$conn->close();
?>
