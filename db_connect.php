<?php
$servername = "localhost"; // Default XAMPP server
$username = "Justus Sheria"; // Default MySQL username
$password = "Juskidraos360@"; // No password for XAMPP
$database = "buy_home"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
