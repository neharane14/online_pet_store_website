<?php
session_start();
include 'dbConnection.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id = $_POST['id'];
    $pet_name = $_POST['name'];
    $pet_price = $_POST['price'];
    $pet_image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    // Insert into database
    $sql = "INSERT INTO orderss (pet_name, pet_price, quantity, total_price, pet_image) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdids", $pet_name, $pet_price, $quantity, $total_price, $pet_image);

    if ($stmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
