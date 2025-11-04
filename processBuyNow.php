<?php
require 'dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerName = $conn->real_escape_string($_POST['customerName']);
    $mobileNumber = $conn->real_escape_string($_POST['mobileNumber']);
    $address = $conn->real_escape_string($_POST['address']);
    $paymentMethod = $conn->real_escape_string($_POST['paymentMethod']);
    $cartItems = json_decode($_POST['cartData'], true);

    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['quantity'] * $item['price'];
    }

    // Insert into `buy_now` table
    $sqlBuyNow = "INSERT INTO buy_now (customerName, mobileNumber, address, paymentMethod, total_price) 
                  VALUES ('$customerName', '$mobileNumber', '$address', '$paymentMethod', '$totalPrice')";

    if ($conn->query($sqlBuyNow) === TRUE) {
        $buyNowId = $conn->insert_id; // Get the last inserted ID

        // Insert each item into `buy_now_details`
        foreach ($cartItems as $item) {
            $petName = $conn->real_escape_string($item['name']);
            $petPrice = (float)$item['price'];
            $quantity = (int)$item['quantity'];
            $itemTotal = $petPrice * $quantity;

            $stmt = $conn->prepare("INSERT INTO buy_now_details (buy_now_id, pet_name, pet_price, quantity, total_price) 
                                    VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isddd", $buyNowId, $petName, $petPrice, $quantity, $itemTotal);
            $stmt->execute();
            $stmt->close();
        }

        echo "success";  // Success response
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
