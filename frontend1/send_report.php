<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$database = "loginandanalysis";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(['message' => "Connection failed: " . $conn->connect_error]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $fixedPassword = 'password123'; // Define a fixed password for new users

    $userCreated = false;

    // Check if the user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // User does not exist, insert a new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $fixedPassword);
        $stmt->execute();
        $userCreated = true;
    }

    $stmt->close();

    // Send an email with the report attachment
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sassegmify@outlook.com';
        $mail->Password = 'sas112000';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('sassegmify@outlook.com', 'SAS Segmify');
        $mail->addAddress($email, $name);

        if ($userCreated) {
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to SAS Segmify';
            $mail->Body    = "Hi $name,<br>Your account has been created. Here are your login details:<br>Email: $email<br>Password: $fixedPassword<br><br>You can view your report <a href='link_to_report'>here</a>.";
        } else {
            $mail->isHTML(false);
            $mail->Subject = 'Monthly Report';
            $mail->Body    = "Dear $name,\n\nPlease find attached the monthly report.\n\nBest regards,\nSAS Segmify";
        }

        $mail->addAttachment('static/reports/monthly_report.pdf');
        $mail->send();
        echo json_encode(['message' => "Email has been sent successfully."]);
    } catch (Exception $e) {
        echo json_encode(['message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

$conn->close();
?>
