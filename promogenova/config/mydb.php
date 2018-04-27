<?php
$servername = "localhost";
$username = "root";
$password = "YOURPASSWORD";
$dbname = "gh_promogenova";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Change character set to utf8
mysqli_set_charset($conn,"utf8");

?>
