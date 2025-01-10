<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start(); // Start the session

$servername = "sql12.freesqldatabase.com";
$username = "sql12756836";
$password = "qEaH9rPgZn";
$database = "sql12756836";

header('Content-Type: application/json'); // Ensure the response is JSON
$response = []; // Initialize response array

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(['message' => "Connection failed: " . $conn->connect_error]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['message' => "Error: User is not logged in."]);
        exit();
    }

    $senderId = $_SESSION['user_id']; // Logged-in user's ID
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $fixedPassword = 'password123'; // Define a fixed password for new users

    $userCreated = false;
    $userId = null;

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
        $userId = $stmt->insert_id;
        $userCreated = true;
    } else {
        // User exists, fetch the user ID
        $user = $result->fetch_assoc();
        $userId = $user['id'];
    }

    $stmt->close();

    // Send an email with the report attachment
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.strato.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'service@nexoskills.com';
        $mail->Password = 'Asdfasdf1!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('service@nexoskills.com', 'NexoSkills Service');
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

        $reportPath = "static/reports/monthly_report.pdf";
        if (file_exists($reportPath)) {
            $mail->addAttachment($reportPath);
        } else {
            echo json_encode(['message' => "Report file not found."]);
            exit();
        }

        $mail->send();

        // Insert report information into user_reports table
        $stmt = $conn->prepare("INSERT INTO user_reports (user_id, report_path) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $reportPath);
        $stmt->execute();
        $reportId = $stmt->insert_id;
        $stmt->close();

        // Insert notification into user_notifications table
        $stmt = $conn->prepare("INSERT INTO user_notifications (sender_id, receiver_id, report_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $senderId, $userId, $reportId);
        $stmt->execute();
        $stmt->close();

        $response['message'] = "Email has been sent successfully.";
    } catch (Exception $e) {
        $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

echo json_encode($response);
$conn->close();
?>
