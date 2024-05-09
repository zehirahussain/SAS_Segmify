<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "loginandanalysis";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare statement
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

// Bind parameters
$stmt->bind_param("sss", $name, $email, $password);

// Set parameters and execute
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password']; // Hash password for security
$stmt->execute();

// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to registration page or any other page
header("Location: loginnnn.html");
exit();
?>