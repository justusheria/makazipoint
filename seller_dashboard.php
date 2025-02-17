<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'seller') {
    header("Location: index.html");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
   
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5e1c5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            text-align: center;
        }
        .tabs {
            display: flex;
            justify-content: space-around;
            background-color: #8B5E3C;
            padding: 10px;
            border-radius: 10px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #d2691e;
            color: white;
            border-radius: 5px;
        }
        .tab:hover {
            background-color: #a0522d;
        }
        .tab-content {
            display: none;
            padding: 20px;
        }
        .active {
            display: block;
        }
        .logout {
            background-color: red;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Seller: <?php echo $username; ?></h2>

    <div class="tabs">
        <div class="tab" onclick="showTab('properties')">My Properties</div>
        <div class="tab" onclick="showTab('notifications')">Notifications</div>
        <div class="tab" onclick="showTab('account')">My Account</div>
        <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <div id="properties" class="tab-content active">
        <h3>My Properties</h3>
       

        <form method="GET">
            Category: <input type="text" name="category">
            Min Price: <input type="number" name="min_price">
            Max Price: <input type="number" name="max_price">
            <button type="submit">Search</button>
        </form>

        <button onclick="showTab('postItem')">Post New Item</button>

        <?php
        $query = "SELECT * FROM properties WHERE seller_username='$username'";

        if (isset($_GET['category']) && $_GET['category'] !== "") {
            $category = $_GET['category'];
            $query .= " AND item_category LIKE '%$category%'";
        }

        if (isset($_GET['min_price']) && $_GET['min_price'] !== "") {
            $min_price = $_GET['min_price'];
            $query .= " AND cost >= $min_price";
        }

        if (isset($_GET['max_price']) && $_GET['max_price'] !== "") {
            $max_price = $_GET['max_price'];
            $query .= " AND cost <= $max_price";
        }

        $result = $conn->query($query);





 















        

        while ($row = $result->fetch_assoc()) {
            echo "<div>
                    <p>Category: " . $row['item_category'] . "</p>
                    <p>Price: " . $row['cost'] . "</p>
                    <p>Location: " . $row['location'] . "</p>
                    <button onclick=\"showDetails(" . $row['id'] . ")\">More</button>
                  </div>";
        }
        ?>
    </div>

    <div id="notifications" class="tab-content">
    <h2>Notifications</h2>
<table>
    <tr>
        <th>Buyer</th>
        <th>Item</th>
        <th>Price</th>
        <th>Location</th>
        <th>Phone</th>
        <th>Posted on</th>
    </tr>

    <?php
    $seller_username = $_SESSION['username'];
    $notif_query = "SELECT * FROM notifications WHERE seller_username = '$seller_username' ORDER BY created_at DESC";
    $notif_result = $conn->query($notif_query);

    while ($notif = $notif_result->fetch_assoc()) {
        echo "<tr>
            <td>{$notif['buyer_username']}</td>
            <td>{$notif['item_category']}</td>
            <td>{$notif['price']}</td>
            <td>{$notif['location']}</td>
            <td>{$notif['buyer_phone']}</td>
            <td>{$notif['created_at']}</td>
            
        </tr>";
    }
    ?>
</table>

    </div>

    <div id="account" class="tab-content">
        <h3>Edit Account</h3>
        <form action="update_account.php" method="POST">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password">
            <button type="submit">Update</button>
        </form>
    </div>

    <div id="postItem" class="tab-content">
        <h3>Post New Item</h3>
  




 
<form action="upload_item.php" method="POST" enctype="multipart/form-data" class="styled-form">
    <input type="text" name="item_category" placeholder="Item Category" required>
    <input type="text" name="location" placeholder="Location" required>
    <input type="number" name="cost" placeholder="Cost" required>
    <input type="text" name="phone1" placeholder="Phone Number 1" required>
    <input type="text" name="phone2" placeholder="Phone Number 2 (Optional)">
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="file" name="image" required>
    <button type="submit">Post Item</button>
</form>

<style>
    .styled-form {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        margin: auto;
        display: flex;
        flex-direction: column;
    }
    .styled-form input, 
    .styled-form textarea {
        width: 95%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }
    .styled-form textarea {
        height: 80px;
        resize: none;
    }
    .styled-form input:focus, 
    .styled-form textarea:focus {
        outline: none;
        border-color: #8b5e3b;
        box-shadow: 0 0 5px rgba(139, 94, 59, 0.5);
    }
    .styled-form button {
        width: 100%;
        padding: 12px;
        background-color: #8b5e3b;
        color: white;
        font-size: 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }
    .styled-form button:hover {
        background-color: #6e482a;
    }
</style>




    </div>
</div>

<script>
    function showTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
    }
</script>

</body>
</html>