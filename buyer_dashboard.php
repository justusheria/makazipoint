<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'buyer') {
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
    <title>Buyer Dashboard</title>
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
        .search-container {
            margin: 20px 0;
            padding: 10px;
            background: #fff3e0;
            border-radius: 10px;
        }
        .card {
            display: flex;
            justify-content: space-between;
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
        }
        .card-content {
            flex: 1;
            padding-left: 15px;
            text-align: left;
        }
        .card-buttons {
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Buyer: <?php echo $username; ?></h2>
    
    <div class="tabs">
        <div class="tab" onclick="showTab('browse')">Browse Properties</div>
        <div class="tab" onclick="showTab('notifications')">Notifications</div>
        <div class="tab" onclick="showTab('account')">My Account</div>
        <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <div id="browse" class="tab-content active">
        <h3>Available Properties</h3>

        <!-- Search Form -->
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search location, category, or seller">
                <input type="number" name="min_price" placeholder="Min price">
                <input type="number" name="max_price" placeholder="Max price">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php
        include 'db_connect.php'; 
        $search_query = "SELECT * FROM properties WHERE 1  ";
        
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $search = $_GET['search'] ?? '';
            $min_price = $_GET['min_price'] ?? '';
            $max_price = $_GET['max_price'] ?? '';
            
            if (!empty($search)) {
                $search_query .= " AND (location LIKE '%$search%' OR item_category LIKE '%$search%' OR seller_username LIKE '%$search%')   
                ORDER BY created_at DESC";
            }
            if (!empty($min_price)) {
                $search_query .= " AND cost >= $min_price";
            }
            if (!empty($max_price)) {
                $search_query .= " AND cost <= $max_price";
            }  
        }

        $result = $conn->query($search_query);
        ?>

        <!-- Display Properties as Cards -->
        <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
            <img src="<?php echo $row['image_path']; ?>" alt="Property Image">
            <div class="card-content">
                <strong>Seller:</strong> <?php echo $row['seller_username']; ?><br>
                <strong>Category:</strong> <?php echo $row['item_category']; ?><br>
                <strong>Location:</strong> <?php echo $row['location']; ?><br>
                <strong>Phone:</strong> <?php echo $row['phone1']; ?><br>
            </div>

            <div class="card-buttons">
                <strong>Price:</strong> <?php echo $row['cost']; ?><br>
                <strong>Date:</strong> <?php echo $row['created_at']; ?><br>
                <button onclick="sendNotification('<?php echo $row['id']; ?>')">I Need This</button>
                <a href="view_item.php?id=<?= $row['id'] ?>" class="more-btn">More</a>
            </div>
        </div>
        <?php } ?>
    </div>

    <div id="notifications" class="tab-content">
        <h3>No New Notifications</h3>
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
</div>

<script>
function sendNotification(itemId) {
    if (confirm("Are you sure you need this item?")) {
        window.location.href = "send_notification.php?item_id=" + itemId;
    }
}

function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
}
</script>

</body>
</html>
