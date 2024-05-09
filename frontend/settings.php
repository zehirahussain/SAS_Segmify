<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "loginandanalysis";
session_start();

// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Prepare and execute SQL query to retrieve user details
$sql = "SELECT name, password FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch user details
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $password = $row['password'];
} else {
    // Handle case where user details are not found
    $name = "Name not found";
    $password = "Password not found";
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
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
        p {
            margin-bottom: 10px;
        }
        button {
            margin-right: 10px;
        }
        .BOX {
            border-radius: 27px;
            font-family: calibri;
            background-color: aliceblue;
            text-align: center;
            padding: 100px 0px 80px 0px;
            width: 34vw;
        }

        .button {
            background-color: #005288;
            border: none;
            color: white;
            padding: 3px 30px;
            text-align: center;
            text-decoration: none;
            display: block;
            font-size: 12.5px;
            margin: auto; /* Center horizontally */
            margin-top: 10px; /* Add some space between buttons */
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            flex: 1;
        }
        
    </style>
</head>
<body>
    <div class="BOX">
        <h1>User Settings</h1>
        <form action="update.php" method="post">
            <p>Name: </p>
            <input type="text" class="req" name="name" value="<?php echo $name; ?>">
            <br>
            <p>Email:</p> 
            <input type="text" class="req" name="email" value="<?php echo $email; ?>">
            <br>
            <p>Password:</p>
            <input type="text" class="req" name="password" value="<?php echo $password; ?>">
            <br>
            <button type="submit" class="button">Update</button>
            <br>
        </form>
        <a href="index.php"><button class="button">Delete Account</button></a>
        <br>
        <a href="segmentationandrevenue.html"><button class="button">Back</button></a>
    </div>
</body>
</html>

       