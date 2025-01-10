<?php
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update user record in the database
    $sql = "UPDATE users SET name='$name', password='$password' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to user settings page
        header("Location: settings.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
