<?php
require 'dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $orderId = intval($_POST['order_id']);

    // Delete order details from `orderss`
    $deleteOrderDetails = "DELETE FROM orderss WHERE order_id = ?";
    $stmt1 = $conn->prepare($deleteOrderDetails);
    $stmt1->bind_param("i", $orderId);
    $stmt1->execute();
    $stmt1->close();

    // Delete order from `orders`
    $deleteOrder = "DELETE FROM orders WHERE order_id = ?";
    $stmt2 = $conn->prepare($deleteOrder);
    $stmt2->bind_param("i", $orderId);
    if ($stmt2->execute()) {
        echo "<script>alert('Order deleted successfully!'); window.location.href='manageOrders.php';</script>";
    } else {
        echo "<script>alert('Error deleting order!'); window.location.href='manageOrders.php';</script>";
    }
    $stmt2->close();

    $conn->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='manageOrders.php';</script>";
}
?>
