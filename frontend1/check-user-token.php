<?php
// check_user_token.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

// Replace 'user@example.com' with the email of the user trying to reset their password
$email = $user['email'];

$stmt = $conn->prepare("SELECT id, email, reset_token, reset_token_expiry FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "User found:<br>";
    echo "ID: " . $user['id'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
    echo "Reset Token: " . ($user['reset_token'] ? $user['reset_token'] : 'No token') . "<br>";
    echo "Token Expiry: " . ($user['reset_token_expiry'] ? $user['reset_token_expiry'] : 'No expiry date') . "<br>";
} else {
    echo "No user found with email: " . $email;
}

$stmt->close();
$conn->close();
?>
