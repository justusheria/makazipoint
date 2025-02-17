<?php
include 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Plaintext password

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Get user type
    $user_type = $_POST['user_type'];

    // SQL query to insert the user data into the database
    $sql = "INSERT INTO users (full_name, username, phone, email, password, user_type) 
            VALUES ('$full_name', '$username', '$phone', '$email', '$hashed_password', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully!";
        // Optionally, redirect to login page or other
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
