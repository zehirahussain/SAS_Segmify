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

$checkEmailStmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$checkEmailStmt->bind_param("s", $email);
$checkEmailStmt->execute();
$result = $checkEmailStmt->get_result(); // Get the result

// Check if an email exists
if ($result->num_rows > 0) {
    echo json_encode(['message' => 'Email already exists']);
    exit();
}

// Prepare statement
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

// Bind parameters
$stmt->bind_param("sss", $name, $email, $password);

// Set parameters and execute
$name = $_POST['name'];
$email = $_POST['email'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['message' => 'Invalid email format']); 
    exit(); 
} 

$password = $_POST['password']; // Hash password for security
$stmt->execute();

// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to registration page or any other page
header("Location: loginnnn.html");
exit();
?>