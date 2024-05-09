<?php
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

// Handle deletion request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Delete user record from the database
    $sql = "DELETE FROM users WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        // Destroy session and redirect to confirmation page or login page
       session_unset();
       session_destroy();
       echo "Record deleted successfully.";

        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
