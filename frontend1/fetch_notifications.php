<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['message' => "Error: User is not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch pending notifications for the logged-in user
$query = "SELECT n.id, u.name AS sender_name, r.report_path 
          FROM user_notifications n
          JOIN users u ON n.sender_id = u.id
          JOIN user_reports r ON n.report_id = r.id
          WHERE n.receiver_id = ? AND n.status = 'pending'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode($notifications);
?>
