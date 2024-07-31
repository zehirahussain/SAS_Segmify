<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "loginandanalysis";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_GET['name'];

$stmt = $conn->prepare("SELECT name, email FROM users WHERE name LIKE ?");
$searchTerm = "%" . $name . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($users);
?>
