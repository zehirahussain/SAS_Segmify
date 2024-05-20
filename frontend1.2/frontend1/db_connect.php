<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginandanalysis";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// sql to delete a record
$sql = "DELETE FROM users WHERE id ='$id'";

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
