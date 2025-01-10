<?php
session_start();
require 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['message' => "Error: User is not logged in."]);
    exit();
}

if (!isset($data['notification_id']) || !isset($data['status'])) {
    echo json_encode(['message' => "Error: Missing parameters."]);
    exit();
}

$notification_id = $data['notification_id'];
$status = $data['status'];

if ($status === 'accepted') {
    // Update the status to 'accepted'
    $query = "UPDATE user_notifications SET status = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $notification_id);
    if ($stmt->execute()) {
        echo json_encode(['message' => "Report accepted successfully."]);
    } else {
        echo json_encode(['message' => "Error updating status: " . $stmt->error]);
    }
} elseif ($status === 'rejected') {
    // Delete the notification if rejected
    $query = "DELETE FROM user_notifications WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $notification_id);
    if ($stmt->execute()) {
        echo json_encode(['message' => "Report rejected and removed."]);
    } else {
        echo json_encode(['message' => "Error deleting notification: " . $stmt->error]);
    }
} else {
    echo json_encode(['message' => "Invalid status provided."]);
}
?>
