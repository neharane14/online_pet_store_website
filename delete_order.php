<?php
session_start();
require 'dbConnection.php'; // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Delete order from database
    $sql = "DELETE FROM ordersss WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        header("Location: order.php?msg=Order deleted successfully");
    } else {
        header("Location: order.php?error=Failed to delete order");
    }

    $stmt->close();
}

$conn->close();
?>
