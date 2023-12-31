<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "solsystem";

// Create a MySQLi connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>