<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php';

// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "loginandanalysis";

// $conn = new mysqli($servername, $username, $password, $database);

// if ($conn->connect_error) {
//     echo json_encode(['message' => "Connection failed: " . $conn->connect_error]);
//     exit();
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = htmlspecialchars($_POST['name']);
//     $email = htmlspecialchars($_POST['email']);
//     $fixedPassword = 'password123'; // Define a fixed password for new users

//     $userCreated = false;

//     // Check if the user exists
//     $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
//     $stmt->bind_param("s", $email);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows == 0) {
//         // User does not exist, insert a new user
//         $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
//         $stmt->bind_param("sss", $name, $email, $fixedPassword);
//         $stmt->execute();
//         $userCreated = true;
//     }

//     $stmt->close();

//     // Send an email with the report attachment
//     $mail = new PHPMailer(true);
//     try {
//         $mail->isSMTP();
//         $mail->Host = 'smtp.strato.com'; // Updated SMTP host
//         $mail->SMTPAuth = true;
//         $mail->Username = 'service@nexoskills.com'; // Updated email address
//         $mail->Password = 'Asdfasdf1!'; // Updated password
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL encryption
//         $mail->Port = 465; // SSL port (alternatively use 587 for TLS)

//         $mail->setFrom('service@nexoskills.com', 'NexoSkills Service');
//         $mail->addAddress($email, $name);

//         if ($userCreated) {
//             $mail->isHTML(true);
//             $mail->Subject = 'Welcome to SAS Segmify';
//             $mail->Body    = "Hi $name,<br>Your account has been created. Here are your login details:<br>Email: $email<br>Password: $fixedPassword<br><br>You can view your report <a href='link_to_report'>here</a>.";
//         } else {
//             $mail->isHTML(false);
//             $mail->Subject = 'Monthly Report';
//             $mail->Body    = "Dear $name,\n\nPlease find attached the monthly report.\n\nBest regards,\nSAS Segmify";
//         }

//         $mail->addAttachment('static/reports/monthly_report.pdf');
//         $mail->send();
//         echo json_encode(['message' => "Email has been sent successfully."]);
//     } catch (Exception $e) {
//         echo json_encode(['message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
//     }
// }

// // Assuming you have the report generated and its path
// $reportPath = "static/reports/monthly_report.pdf"; // Replace with your actual report path

// // Insert report information into user_reports table
// $stmt = $conn->prepare("INSERT INTO user_reports (user_id, report_path) VALUES (?, ?)");
// $stmt->bind_param("is", $userId, $reportPath); // $userId is the ID of the user sending the report
// $stmt->execute();
// $stmt->close();


// $conn->close();
?>
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
    $userId = null; // Initialize userId

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
        $userId = $stmt->insert_id; // Get the ID of the newly created user
        $userCreated = true;
    } else {
        // User exists, fetch the user ID
        $user = $result->fetch_assoc();
        $userId = $user['id']; // Assuming 'id' is the user ID column
    }

    $stmt->close();

    // Send an email with the report attachment
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.strato.com'; // Updated SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'service@nexoskills.com'; // Updated email address
        $mail->Password = 'Asdfasdf1!'; // Updated password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL encryption
        $mail->Port = 465; // SSL port (alternatively use 587 for TLS)

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

        // Check if the report file exists before attaching
        $reportPath = "static/reports/monthly_report.pdf"; // Replace with your actual report path
        if (file_exists($reportPath)) {
            $mail->addAttachment($reportPath);
        } else {
            echo json_encode(['message' => "Report file not found."]);
            exit();
        }

        $mail->send();
        echo json_encode(['message' => "Email has been sent successfully."]);

        // Insert report information into user_reports table
        $stmt = $conn->prepare("INSERT INTO user_reports (user_id, report_path) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $reportPath); // Use the correct user ID
        $stmt->execute();
        $stmt->close();

    } catch (Exception $e) {
        echo json_encode(['message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

// Close the connection
$conn->close();
