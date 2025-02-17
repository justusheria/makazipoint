<?php
include 'db_connect.php'; // Include database connection

// Check if item ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$item_id = $_GET['id']; // Get the item ID from URL

// Fetch item details from the database
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Item not found.");
}

$item = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Item</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { 
            max-width: 500px;
            margin: auto;
            padding: 30px; 
            border: 1px solid #ddd; 
            border-radius: 10px; 
            background:rgb(195, 170, 151);
            text-align: left;
             gap: 1px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            
        }


    img:hover {
    transform: scale(1.05);}

        img { max-width: 100%;
            height: auto; 
            display: block;
            margin-bottom: 10px; 
            border-radius: 8px; }


            img {
    border-radius: 10px;
    margin-top: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease-in-out;}

        .back-btn, .need-btn { display: inline-block; padding: 10px 15px; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px; border: none; cursor: pointer; }
        .back-btn { background: #007bff; }
        .back-btn:hover { background: rgb(229, 6, 6); }
        .need-btn { background: #007bff; }
        .need-btn:hover { background: rgb(12, 128, 6); }
    </style>


</head>
<body>

<div class="container">
    <h2>Item Details</h2>

    <?php if (!empty($item['image_path'])): ?>
        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="Item Image">
    <?php else: ?>
        <p>No image available</p>
    <?php endif; ?>

    <p><strong>Seller:</strong> <?= htmlspecialchars($item['seller_username']) ?></p>
    <p><strong>Item Id Number:</strong> <?= htmlspecialchars($item['id']) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($item['item_category']) ?></p>
    <p><strong>Price:</strong> Tsh: <?= htmlspecialchars($item['cost']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($item['location']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($item['phone1']) ?><?= !empty($item['phone2']) ? ', ' . htmlspecialchars($item['phone2']) : '' ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($item['description'])) ?></p>

    <a href="buyer_dashboard.php" class="back-btn">Back</a>
    <button class="need-btn" onclick="sendNotification(<?= $item['id']; ?>)">I Need This</button> 
</div>

<script>
function sendNotification(itemId) {
    if (confirm("Are you sure you need this item?")) {
        window.location.href = "send_notification.php?item_id=" + itemId;
    }
}
</script>

</body>
</html>
