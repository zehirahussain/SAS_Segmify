<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];

    // Set email recipient and subject
    $to = "sassegmify@example.com"; 
    $subject = "New Contact Form Submission";


    $message = "Name: $name\n";
    $message .= "Email: $email\n\n";
    $message .= "Comment/Question:\n$comment";

    
    if (mail($to, $subject, $message)) {
        echo "Thank you for your message! We will get back to you soon.";
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}
?>
