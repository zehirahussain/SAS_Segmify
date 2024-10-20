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
            padding: 220px 20px;
            background-color: aliceblue;
            text-align: center;
            width: 625px; /* Adjust the width as needed */
            margin: 0 auto; /* Centers the div horizontally */
        }
        .input-group {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        .input-group input {
            margin-right: 10px;
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
        <!-- Display notification message -->
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
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>         
        <!-- <form action="update_password.php" method="POST">
            <div class="input-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required minlength="8">
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
            </div>
            <button type="submit">Reset Password</button>
        </form> -->
    </div>
</body>
</html>
