<?php
require 'dbConnection.php';

// Query all orders, sorted by latest first
$sql = "SELECT * FROM ordersss ORDER BY created_at ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="styles.css"> <!-- Your main CSS file -->
    <link rel="stylesheet" href="adminPanel.css">
    <style>
           body {
            font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    color: #333;
        }

        *{
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
    padding: 0;
    margin: 0;
    outline: none; border: none;
    text-decoration: none;
    text-transform: capitalize;
    transition: .2s linear;
    
}
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #ff8c00;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .pet-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .container {
            max-width: 1500px;
            margin: auto;
        }

        select {
    color: black !important;
    font-weight: bold;
}

option[value="Pending"] {
    color: red;
}

option[value="Paid"] {
    color: green;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Pet Image</th>
                    <th>Pet Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Customer Name</th>
                    <th>Mobile Number</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th> <!-- Added Payment Status -->
                    <th>Order Date</th>
                    <th>Pickup Date</th>
                    <th>Created At</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['order_id']) ?></td>
                    <td>
                        <img src="<?= htmlspecialchars($row['pet_image']) ?>" alt="<?= htmlspecialchars($row['pet_name']) ?>" class="pet-image">
                    </td>
                    <td><?= htmlspecialchars($row['pet_name']) ?></td>
                    <td>₹<?= number_format($row['pet_price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td>₹<?= number_format($row['total_price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= htmlspecialchars($row['mobile_number']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['payment_method']) ?></td>
                    <td>
                    <form action="updatePaymentStatus.php" method="POST">
        <input type="hidden" name="order_id" value="<?= htmlspecialchars($row['order_id']) ?>">
        <select name="payment_status" style="color: black; font-weight: bold;" onchange="this.form.submit()">
            <option value="Pending" style="color: red;" <?= $row['payment_status'] == "Pending" ? "selected" : "" ?>>Pending</option>
            <option value="Paid" style="color: green;" <?= $row['payment_status'] == "Paid" ? "selected" : "" ?>>Paid</option>
        </select>
    </form>
                    </td>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                    <td><?= htmlspecialchars($row['pickup_date']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
