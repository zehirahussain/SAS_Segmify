<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('graph.jpeg');
            background-size: cover;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .BOX {
            border-radius: 27px;
            padding: 205px 20px;
            background-color: aliceblue;
            text-align: center;
            width: 625px;
            margin: 0 auto;
        }
        button {
            background-color: #005288;
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            margin-top: 15px;
        }
        button:hover {
            background-color: #003d66;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="BOX">
        <h1>Reset Password</h1>
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-info" role="alert">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
        <form action="update_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                <div class="form-text">Password must be at least 8 characters long and contain at least one number and one special character</div>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $error_message = '';

        // Password validation
        if (!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/', $new_password)) {
            $error_message = 'Password must be at least 8 characters long and contain at least one number and one special character';
        } elseif ($new_password !== $confirm_password) {
            $error_message = 'Passwords do not match';
        }

        if ($error_message) {
            echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($error_message) . '</div>';
        } else {
            // Proceed with password update logic
            // Example: Update the password in the database
            $token = $_POST['token'];
            // Assuming you have a database connection $conn
            $conn = new mysqli("localhost", "username", "password", "database");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE token = ?");
            $stmt->bind_param("ss", $hashed_password, $token);
            if ($stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">Password has been reset successfully</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error updating password. Please try again.</div>';
            }
            $stmt->close();
            $conn->close();
        }
    }
    ?>
</body>
</html>
