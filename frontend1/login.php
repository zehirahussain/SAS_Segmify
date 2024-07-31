<?php
// Start session
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "loginandanalysis";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if user exists
    $sql = "SELECT id, email, password FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, set session variables and redirect to dashboard
        $row = $result->fetch_assoc();
        $userId = $row['id'];  // Access the fetched ID
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $row['name']; // Store the name in the session
        $updateLoginStatus = "UPDATE users SET current_login = TRUE WHERE id = $userId";
        $conn->query($updateLoginStatus);
        header('Location: decisionn.php');
        exit;
    } else {
        // User not found, redirect back to login page with error message
        $_SESSION['error'] = "Invalid email or password";
        header('Location: loginnnn.html');
        exit;
    }
}

// Close connection
$conn->close();
?>
