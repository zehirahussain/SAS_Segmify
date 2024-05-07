<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['message' => 'You are not logged in']);
        exit();
    }

    require_once 'db_connect.php';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT name, email FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(['name' => $row['name'], 'email' => $row['email']]);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'User not found']);
    }

    mysqli_close($conn);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user settings
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Delete user account
}
?>
