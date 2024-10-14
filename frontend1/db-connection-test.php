<?php
// db_connection_test.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to the database.<br>";

// Test query
$result = $conn->query("SELECT 1");
if ($result) {
    echo "Successfully ran a test query.<br>";
} else {
    echo "Failed to run test query: " . $conn->error . "<br>";
}

$conn->close();
?>
