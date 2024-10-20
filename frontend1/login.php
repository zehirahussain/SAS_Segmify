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
    echo json_encode(["message" => "Database connection failed"]);
    exit();
}

// Form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if user exists
    $sql = "SELECT id, email, password, name FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, now check if password is correct
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            // Password is correct, set session variables
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['name']; // Store the name in the session

            // Update login status
            $updateLoginStatus = "UPDATE users SET current_login = TRUE WHERE id = ?";
            $stmt = $conn->prepare($updateLoginStatus);
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();

            echo json_encode(["message" => "Login successful"]);
        } else {
            // Password is incorrect
            echo json_encode(["message" => "Wrong password"]);
        }
    } else {
        // User doesn't exist
        echo json_encode(["message" => "User doesn't exist. Please sign up."]);
    }
}

$conn->close();
?>
