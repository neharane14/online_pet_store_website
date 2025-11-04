<?php
// Include the database connection file
include('dbConnection.php');

// Check if pet_id is passed in the URL
if (isset($_GET['id'])) {
    $pet_id = $_GET['id'];

    // SQL query to fetch the pet details by pet_id
    $sql = "SELECT * FROM pets WHERE pet_id = $pet_id";
    $result = $conn->query($sql);

    // Check if the pet is found
    if ($result->num_rows > 0) {
        // Fetch the pet details
        $pet = $result->fetch_assoc();
    } else {
        echo "Pet not found.";
        exit;
    }
} else {
    echo "No pet ID provided.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="pet-details-container">
        <h1><?php echo $pet['pet_name']; ?></h1>
        <div class="pet-details">
            <div class="pet-image">
                <img src="<?php echo $pet['image_url']; ?>" alt="<?php echo $pet['pet_name']; ?>" width="300">
            </div>
            <div class="pet-info">
                <p><strong>Type:</strong> <?php echo $pet['pet_type']; ?></p>
                <p><strong>Breed:</strong> <?php echo $pet['breed']; ?></p>
                <p><strong>Price:</strong> ₹<?php echo $pet['price']; ?></p>
                <p><strong>Description:</strong> <?php echo $pet['description']; ?></p>
                <p><strong>Stock Quantity:</strong> <?php echo $pet['stock_quantity']; ?></p>
            </div>
        </div>
        <a href="addToCart.php?id=<?php echo $pet['pet_id']; ?>" class="add-to-cart-btn">Add to Cart</a>
    </div>
</body>
</html>
