<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM properties WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        echo "Property not found.";
        exit();
    }
} else {
    echo "No property ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Property Details</title>
</head>
<body>
    <h2>Property Details</h2>
    <p><strong>Seller:</strong> <?php echo $item['seller_username']; ?></p>
    <p><strong>Category:</strong> <?php echo $item['item_category']; ?></p>
    <p><strong>Price:</strong> <?php echo $item['cost']; ?></p>
    <p><strong>Location:</strong> <?php echo $item['location']; ?></p>
    <p><strong>Phone:</strong> <?php echo $item['phone1']; ?></p>
    <p><strong>Description:</strong> <?php echo $item['description']; ?></p>
</body>
</html>
