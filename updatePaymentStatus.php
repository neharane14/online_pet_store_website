<?php
require 'dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"]) && isset($_POST["payment_status"])) {
    $order_id = intval($_POST["order_id"]);
    $payment_status = $_POST["payment_status"];

    $sql = "UPDATE ordersss SET payment_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $payment_status, $order_id);

    if ($stmt->execute()) {
        header("Location: manageOrders.php"); // Redirect to the order management page
        exit();
    } else {
        echo "Error updating payment status: " . $conn->error;
    }
}
?>
