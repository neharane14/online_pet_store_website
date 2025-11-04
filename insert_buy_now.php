<?php
session_start();
include 'dbConnection.php';

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h3>Received POST Data:</h3><pre>";
    print_r($_POST);
    echo "</pre>";

    // Retrieve form values
    $pet_id = $_POST['pet_id'] ?? '';
    $pet_name = $_POST['pet_name'] ?? '';
    $pet_price = $_POST['pet_price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $total_price = $_POST['total_price'] ?? '';

    // Validate data
    if (empty($pet_id) || empty($pet_name) || empty($pet_price) || empty($quantity) || empty($total_price)) {
        die("Error: Missing values in form submission.");
    }

    // Prepare SQL query
    $sql = "INSERT INTO buy_now (pet_id, pet_name, pet_price, quantity, total_price) 
            VALUES ('$pet_id', '$pet_name', '$pet_price', '$quantity', '$total_price')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    die("Invalid request.");
}
?>
