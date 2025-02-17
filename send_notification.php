<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    die("You must be logged in.");
}

if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];

    // Retrieve buyer details from session
    $buyer_username = $_SESSION['username'];
    $buyer_query = "SELECT phone FROM users WHERE username = '$buyer_username'";
    $buyer_result = $conn->query($buyer_query);
    $buyer_data = $buyer_result->fetch_assoc();
    $buyer_phone = $buyer_data['phone'];

    // Retrieve item details from properties table
    $item_query = "SELECT * FROM properties WHERE id = $item_id";
    $item_result = $conn->query($item_query);
    if ($item_result->num_rows > 0) {
        $item = $item_result->fetch_assoc();
        $seller_username = $item['seller_username'];
        $category = $item['item_category'];
        $price = $item['cost'];
        $location = $item['location'];
        $date = $item['created_at'];

        // Insert notification into database
        $insert_query = "INSERT INTO notifications (seller_username, buyer_username, item_category, price, location, buyer_phone, created_at)
                         VALUES ('$seller_username', '$buyer_username', '$category', '$price', '$location', '$buyer_phone', '$date')";
        if ($conn->query($insert_query) === TRUE) {
            echo "<script>alert('Notification sent to seller!'); window.location.href='buyer_dashboard.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Item not found.";
    }
} else {
    echo "No item selected.";
}
?>