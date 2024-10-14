<?php
// send_reset_link.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include database connection
include 'db_connect.php';

// Load PHPMailer classes
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in your database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Store the token in your database with an expiration time
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expiry, $email);
        $stmt->execute();

        // Send email with reset link
        $reset_link = "http://localhost/fyp0.3/frontend1/reset_password.php?token=" . $token;

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.strato.com'; // Updated SMTP server for Strato
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'service@nexoskills.com'; // Your Strato email address
            $mail->Password = 'Asdfasdf1!'; // Your Strato email password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to, could also use 465 for SSL

            // Recipients
            $mail->setFrom('service@nexoskills.com', 'NexoSkills Support');
            $mail->addAddress($email); // This sends the reset link to the user's email

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'Click the following link to reset your password: <a href="' . $reset_link . '">' . $reset_link . '</a>';
            $mail->AltBody = 'Click the following link to reset your password: ' . $reset_link;

            $mail->send();

            // Redirect with success message
            header("Location: forgot_password.php?message=A password reset link has been sent to your email.");
            exit(); // Ensure no further code executes after the redirect
        } catch (Exception $e) {
            // Redirect back with error message if email could not be sent
            header("Location: forgot_password.php?message=Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            exit(); // Ensure no further code executes after the redirect
        }
    } else {
        // Redirect back with error message if email not found
        header("Location: forgot_password.php?message=The email address you entered does not exist in our records.");
        exit(); // Ensure no further code executes after the redirect
    }
}
?>
