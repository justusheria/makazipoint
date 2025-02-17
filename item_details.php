<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    $query = "SELECT * FROM properties WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
} else {
    echo "Item not found!";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Item Details ()</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #8B5E3C;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }
        img {
            max-width: 20%;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo $item['item_category']; ?></h2>
        <p><strong>Price:</strong> <?php echo $item['cost']; ?></p>
        <p><strong>Location:</strong> <?php echo $item['location']; ?></p>
        <p><strong>Phone:</strong> <?php echo $item['phone_number_1']; ?></p>
        <p><strong>Description:</strong> <?php echo $item['description']; ?></p>
        <img src="<?php echo $item['image_path']; ?>" alt="Item Image">
    </div>
</body>
</html>