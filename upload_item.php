 <?php
include 'db_connect.php'; // Ensure database connection file is correct
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_username = $_SESSION['username']; // Get seller username from session
    $item_category = $_POST['item_category'] ?? ''; // Handle missing inputs
    $location = $_POST['location'] ?? '';
    $cost = $_POST['cost'] ?? '';
    $phone1 = $_POST['phone1'] ?? ''; // Fix undefined index issue
    $phone2 = $_POST['phone2'] ?? ''; // Optional field
    $description = $_POST['description'] ?? '';




    
    // Handle Image Upload
    $image_path = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/"; // Folder where images are stored
        $image_name = basename($_FILES["image"]["name"]); // Get image name
        $target_file = $target_dir . $image_name; // Full file path
    
        // Move the uploaded file to the "uploads" directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file; // Save file path in database
        } else {
            $image_path = ""; // If upload fails, store empty path
        }
    } else {
        $image_path = ""; // If no image uploaded
    }
    


  

    // Prepare SQL Statement
    $stmt = $conn->prepare("INSERT INTO properties (seller_username, item_category, location, cost, phone1, phone2, description, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $seller_username, $item_category, $location, $cost, $phone1, $phone2, $description, $image_path);

    // Execute Query
    if ($stmt->execute()) {
        echo "Item posted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

