<?php
session_start(); // Start session
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginUser = $_POST['loginUser']; // Username or Email
    $loginPass = $_POST['loginPass']; // Password

    $sql = "SELECT * FROM users WHERE username = '$loginUser' OR email = '$loginUser'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($loginPass, $row['password'])) {
            // Store user data in session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];

            // Redirect to respective dashboard
            if ($row['user_type'] == 'buyer') {
                header("Location: buyer_dashboard.php");
            } else {
                header("Location: seller_dashboard.php");
            }
            exit();
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "No user found with that username/email!";
    }
}

$conn->close();
?>
