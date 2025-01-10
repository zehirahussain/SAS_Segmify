<?php
// check_reset_token.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$token = $user['reset_token']; // Replace with the token from your form

$stmt = $conn->prepare("SELECT id, email, reset_token, reset_token_expiry FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "User found:<br>";
    echo "ID: " . $user['id'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
    echo "Reset Token: " . $user['reset_token'] . "<br>";
    echo "Token Expiry: " . $user['reset_token_expiry'] . "<br>";
    
    // Check if token is expired
    $expiry = new DateTime($user['reset_token_expiry']);
    $now = new DateTime();
    if ($expiry < $now) {
        echo "Token is expired.<br>";
    } else {
        echo "Token is still valid.<br>";
    }
} else {
    echo "No user found with this reset token.";
}

$stmt->close();
$conn->close();
?>
