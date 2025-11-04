<?php
session_start();
require 'dbConnection.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Retrieve user's mobile number
$mobile = $_SESSION['mobile'];

// Fetch orders for the logged-in user
$sql = "SELECT * FROM ordersss WHERE mobile_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $mobile);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>

    <div class="container">
        <h1>My Orders</h1>
        <?php if ($result->num_rows > 0): ?>
            <table border="1">
                <tr>
                    <th>Pet Image</th>
                    <th>Pet Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Pickup Date</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($row['pet_image']) ?>" width="50" height="50"></td>
                    <td><?= htmlspecialchars($row['pet_name']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td>₹<?= number_format($row['total_price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                    <td><?= htmlspecialchars($row['pickup_date']) ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>

        <button onclick="window.location.href='account.php'" class="btn">Back to Account</button>
    </div>

</body>
</html>
