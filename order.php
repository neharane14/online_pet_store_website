<?php
session_start();
require 'dbConnection.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$mobile = $_SESSION['mobile']; // Get the logged-in user's mobile number

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
    <link rel="stylesheet" href="order.css">
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
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($row['pet_image']) ?>" width="50" height="50"></td>
                    <td><?= htmlspecialchars($row['pet_name']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td>₹<?= number_format($row['total_price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                    <td><?= htmlspecialchars($row['pickup_date']) ?></td>
                    <td>
                        <form method="POST" action="delete_order.php" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                            <button type="submit" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>

        <div class="button-container">
        <button onclick="window.location.href='home.php'" class="btn">Back to Home</button>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
