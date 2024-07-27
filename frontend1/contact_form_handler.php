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
        $mail->Host = 'smtp.office365.com'; // For Outlook
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'sassegmify@outlook.com'; // Your Outlook email address
        $mail->Password = 'sas112000'; // Your Outlook password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('your_outlook_email@outlook.com', 'Your Name');
        $mail->addAddress('sassegmify@outlook.com', 'Your Name'); // Replace with your email address

        // Content
        $mail->isHTML(false); // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "Name: $name\nEmail: $email\n\nComment/Question:\n$comment";

        $mail->send();
        echo "Thank you for your message! We will get back to you soon.";
    } catch (Exception $e) {
        echo "Oops! Something went wrong. Please try again later.";
    }
}
?>
