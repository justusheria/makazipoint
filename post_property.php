<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'seller') {
    die("Unauthorized Access");
}

$seller_username = $_SESSION['username'];
$item_category = $_POST['item_category'];
$location = $_POST['location'];
$cost = $_POST['cost'];
$phone1 = $_POST['phone1'];
$phone2 = $_POST['phone2'];
$description = $_POST['description'];

$sql = "INSERT INTO properties (seller_username, item_category, location, cost, phone1, phone2, description) 
        VALUES ('$seller_username', '$item_category', '$location', '$cost', '$phone1', '$phone2', '$description')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Item Posted Successfully'); window.location.href='seller_dashboard.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
