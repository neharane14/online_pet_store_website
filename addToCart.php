<?php
session_start();
include 'dbConnection.php'; // Ensure correct DB connection file

if (isset($_POST['pet_id']) && isset($_SESSION['user_id'])) {
    $pet_id = $_POST['pet_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the pet already exists in the cart
    $checkQuery = "SELECT * FROM cart WHERE user_id = ? AND pet_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $user_id, $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If exists, update quantity
        $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND pet_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ii", $user_id, $pet_id);
        $stmt->execute();
    } else {
        // If not, insert a new row
        $insertQuery = "INSERT INTO cart (user_id, pet_id, quantity) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $user_id, $pet_id);
        $stmt->execute();
    }

    echo "success";
} else {
    echo "error";
}
?>
