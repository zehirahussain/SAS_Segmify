<?php
// update_password.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'db_connect.php';

// Function to log messages
function log_message($message) {
    error_log($message);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    log_message("Received POST request");
    
    // Retrieve POST data
    $token = $_POST['token'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    log_message("Token: " . $token);
    log_message("New Password length: " . strlen($new_password));
    log_message("Confirm Password length: " . strlen($confirm_password));

    // Check for password match
    if ($new_password !== $confirm_password) {
        log_message("Passwords do not match.");
        header("Location: reset_password.php?message=Passwords do not match");
        exit();
    }

    // Check if token is valid
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    if (!$stmt) {
        log_message("Error preparing statement: " . $conn->error);
        header("Location: reset_password.php?message=Internal server error");
        exit();
    }
    $stmt->bind_param("s", $token);
    
    log_message("Executing token check query");
    if (!$stmt->execute()) {
        log_message("Error executing token check query: " . $stmt->error);
        header("Location: reset_password.php?message=Internal server error");
        exit();
    }
    
    $result = $stmt->get_result();
    log_message("Token check query executed. Rows found: " . $result->num_rows);

    if ($result->num_rows > 0) {
        // Valid token, proceed to update password (without hashing)
        $userId = $result->fetch_assoc()['id'];
        
        // Update the password in plain-text
        $update_stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
        if ($update_stmt) {
            $update_stmt->bind_param("si", $new_password, $userId);
            if ($update_stmt->execute()) {
                header("Location: reset_password.php?message=Password reset successful");
            } else {
                log_message("Error executing password update: " . $update_stmt->error);
                header("Location: reset_password.php?message=Internal server error");
            }
            $update_stmt->close();
        } else {
            log_message("Error preparing update statement: " . $conn->error);
            header("Location: reset_password.php?message=Internal server error");
        }
    } else {
        header("Location: reset_password.php?message=Invalid or expired reset token");
    }

    $stmt->close();
} else {
    log_message("Invalid request method. This script only accepts POST requests.");
    header("Location: reset_password.php?message=Invalid request");
}

$conn->close();
?>
