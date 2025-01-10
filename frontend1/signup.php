<?php
// Establish database connection
$servername = "sql12.freesqldatabase.com";
$username = "sql12756836";
$password = "qEaH9rPgZn";
$database = "sql12756836";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['message' => 'Database connection failed']);
    exit();
}

// Get POST data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['message' => 'Invalid email format']);
    exit();
}

// Check if the email already exists
$checkEmailStmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$checkEmailStmt->bind_param("s", $email);
$checkEmailStmt->execute();
$result = $checkEmailStmt->get_result(); 

if ($result->num_rows > 0) {
    echo json_encode(['message' => 'Email already exists']);
    exit();
}


// Insert the new user without hashing the password
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['message' => 'Signup successful!']);
} else {
    echo json_encode(['message' => 'Signup failed. Please try again.']);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>