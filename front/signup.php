<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_connect.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'User created successfully']);
    } else {
        echo json_encode(['message' => 'Error: ' . mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>
