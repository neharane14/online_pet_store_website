<?php
// Include the database connection file
include('dbConnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $pet_name = $_POST['pet_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $stock_quantity = $_POST['stock_quantity'];

    // SQL query to insert new pet
    $sql = "INSERT INTO pets (pet_name, price, description, image_url, stock_quantity) 
            VALUES ('$pet_name', '$pet_type', '$breed', '$price', '$description', '$image_url', '$stock_quantity')";

    if ($conn->query($sql) === TRUE) {
        echo "New pet added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML form to add pet -->
<form method="POST" action="addPet.php">
    <input type="text" name="pet_name" placeholder="Pet Name" required><br>
    <input type="text" name="price" placeholder="Price" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <input type="text" name="image_url" placeholder="Image URL" required><br>
    <input type="number" name="stock_quantity" placeholder="Stock Quantity" required><br>
    <button type="submit">Add Pet</button>
</form>
