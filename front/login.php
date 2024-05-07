<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_connect.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            echo json_encode(['message' => 'Login successful']);
        } else {
            echo json_encode(['message' => 'Invalid email or password']);
        }
    } else {
        echo json_encode(['message' => 'Invalid email or password']);
    }

    mysqli_close($conn);
}
?>
