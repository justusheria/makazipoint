<?php
$host = 'localhost'; // Database host
$username = 'Justus Sheria'; // MySQL username
$password = 'Juskidraos360@'; // MySQL password
$dbname = 'buy_home'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
