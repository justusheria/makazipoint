<?php
include 'db_connect.php';

if (isset($_GET['item_id'])) {
    $item_id = intval($_GET['item_id']);

    // Update impressions count in the database
    $update_query = "UPDATE properties SET impressions = impressions + 1 WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the buyer dashboard
    header("Location: buyer_dashboard.php");
    exit();
}
?>
