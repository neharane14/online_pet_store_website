<?php
require 'dbConnection.php';

$type = $_GET['type']; // Get pet type from query parameter
$pets = $conn->query("SELECT * FROM pets WHERE type='$type'");

$petData = [];
while ($pet = $pets->fetch_assoc()) {
    $petData[] = [
        'id' => $pet['id'],
        'name' => $pet['name'],
        'price' => $pet['price'],
        'image' => $pet['image'],
        'food' => $pet['food'],
        'addToCart' => '<button class="add-to-cart" 
            data-id="'.$pet['id'].'" 
            data-name="'.$pet['name'].'" 
            data-price="'.$pet['price'].'" 
            data-image="'.$pet['image'].'">Add to Cart</button>',
        'buyNow' => '<button class="buy-now" 
            data-id="'.$pet['id'].'" 
            data-name="'.$pet['name'].'" 
            data-price="'.$pet['price'].'" 
            data-image="'.$pet['image'].'">Buy Now</button>'
    ];
}

header('Content-Type: application/json');
echo json_encode($petData);
?>

