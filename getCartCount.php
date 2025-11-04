<?php
session_start();
include 'dbConnection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Get total quantity of all items in the cart for this user
    $query = "SELECT SUM(quantity) AS total FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo ($row['total'] !== null) ? $row['total'] : 0;
} else {
    echo "0"; // If not logged in, return 0
}
?>
