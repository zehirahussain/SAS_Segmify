<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        .BOX {
            border-radius: 27px;
            padding: 40px; /* Reduced padding for better fit */
            background-color: aliceblue;
            text-align: center;
            width: 625px; /* Adjust the width as needed */
            margin: 0 auto; /* Centers the div horizontally */
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
    <div class="container mt-5">
        <h2>Forgot Password</h2>

        <!-- Display notification message -->
        <?php if (isset($_GET['message'])): ?>
    <div class="alert alert-info" role="alert">
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>


        <form action="send_reset_link.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>
</div>
</body>
</html>
