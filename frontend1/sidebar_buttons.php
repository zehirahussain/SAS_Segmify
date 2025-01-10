<?php
// Database connection variables
$servername = "sql12.freesqldatabase.com";
$username = "sql12756836";
$password = "qEaH9rPgZn";
$database = "sql12756836";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch button names from the database
$sql = "SELECT button_name FROM sidebar_buttons";
$result = $conn->query($sql);

$button_names = array("Dashboard", "Segmentation & Revenue", "Review Analysis", "Presentation", "Report", "Back");
foreach ($button_names as $name) {
    echo '<a class="nav-link sidebar-button" href="#">' . $name . '</a>';
}
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<a class="nav-link" href="#">' . $row["button_name"] . '</a>';
    }
} else {
    echo "0 results";
}
$conn->close();
?>
