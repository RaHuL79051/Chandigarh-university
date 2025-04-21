<?php
$host = "localhost";
$username = "root";  // Change if needed
$password = "12345";       // Change if needed
$database = "OMBS";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
