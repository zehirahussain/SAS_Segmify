<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $comment = htmlspecialchars($_POST['comment']);

    $mail = new PHPMailer(true); // Passing `true` enables exceptions
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
        $mail->addAddress('service@nexoskills.com', 'NexoSkills Support'); // Replace with the recipient's email address

        // Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "Name: $name\nEmail: $email\n\nComment/Question:\n$comment";

        $mail->send();
        echo "Thank you for your message! We will get back to you soon.";
    } catch (Exception $e) {
        echo "Oops! Something went wrong. Please try again later. Error: {$mail->ErrorInfo}";
    }
}
?>
