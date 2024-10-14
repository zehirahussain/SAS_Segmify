<?php
// update_password.php

// Include database connection
// include 'db_connect.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $token = $_POST['token'];
//     $new_password = $_POST['new_password'];
//     $confirm_password = $_POST['confirm_password'];
    
//     if ($new_password !== $confirm_password) {
//         die("Passwords do not match.");
//     }
    
//     // Verify the token and check if it's still valid
//     // $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
//     // $stmt->bind_param("s", $token);
//     // $stmt->execute();
//     // $result = $stmt->get_result();
    
//     $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
//     $stmt->bind_param("s", $token);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $user = $result->fetch_assoc();
        
//         // Hash the new password
//         $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
//         // Update the password and clear the reset token
//         $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
//         $stmt->bind_param("si", $hashed_password, $user['id']);
//         $stmt->execute();
        
//         echo "Your password has been successfully reset. You can now log in with your new password.";
//     } else {
//         echo "Invalid or expired reset token.";
//     }
// $stmt->close();
// $conn->close();
// }
?>

<?php
// // Database connection
// include 'db_connect.php';
// // $conn = new mysqli('localhost', 'username', 'password', 'database_name');

// // // Check connection
// // if ($conn->connect_error) {
// //     die("Connection failed: " . $conn->connect_error);
// // }

// // Retrieve POST data
// $token = $_POST['token'];
// $new_password = $_POST['new_password'];
// $confirm_password = $_POST['confirm_password'];

// // Check if the new password matches the confirmation
// if ($new_password !== $confirm_password) {
//     die("Passwords do not match.");
// }

// // Prepare SQL statement to check the token
// $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
// $stmt->bind_param("s", $token);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     // Token is valid, proceed with password update
//     $user = $result->fetch_assoc();
//     $user_id = $user['id']; // Get user ID

//     // Hash the new password
//     $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

//     // Update the password in the database
//     $update_stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
//     $update_stmt->bind_param("si", $hashed_password, $user_id);
//     if ($update_stmt->execute()) {
//         echo "Your password has been successfully reset.";
//     } else {
//         echo "Error updating password: " . $conn->error;
//     }
// } else {
//     echo "Invalid or expired reset token.";
// }

// $conn->close(); // Close the database connection
?>
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

    // Check token
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
        // Proceed to update password
        // Assume $new_password is hashed before saving
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $userId = $result->fetch_assoc()['id'];
        
        $update_stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
        if ($update_stmt) {
            $update_stmt->bind_param("si", $hashed_password, $userId);
            $update_stmt->execute();
            $update_stmt->close();
            header("Location: reset_password.php?message=Password reset successful");
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


