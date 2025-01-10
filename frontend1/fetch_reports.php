
<?php
session_start(); // Ensure session is started

$servername = "sql12.freesqldatabase.com";
$username = "sql12756836";
$password = "qEaH9rPgZn";
$database = "sql12756836";

$conn = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

// Ensure user_id is set in session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    die(json_encode(['error' => "User not logged in"]));
}

// Prepare and execute the statement
$stmt = $conn->prepare("SELECT report_path, created_at FROM user_reports WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$reports = [];
while ($row = $result->fetch_assoc()) {
    $reports[] = $row; // Collect all reports in an array
}

// Return the reports as JSON
echo json_encode($reports);

$stmt->close();
$conn->close();
?>
