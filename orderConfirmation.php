<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'dbConnection.php'; // This file should establish a MySQLi connection in $conn

// ----------------------------
// 1. Retrieve Pet Details from Session
// ----------------------------
if (!isset($_SESSION['pet_id'], $_SESSION['pet_name'], $_SESSION['pet_price'], $_SESSION['pet_quantity'], $_SESSION['pet_image'], $_SESSION['total_price'])) {
    die("Pet details missing from session.");
}

$pet_id      = intval($_SESSION['pet_id']);
$pet_name    = $_SESSION['pet_name'];
$pet_price   = floatval($_SESSION['pet_price']);
$quantity    = intval($_SESSION['pet_quantity']);
$total_price = floatval($_SESSION['total_price']);
$pet_image   = $_SESSION['pet_image'];

// ----------------------------
// 2. Retrieve Customer Details from POST
// ----------------------------
if (!isset($_POST['customer_name'], $_POST['mobile_number'], $_POST['address'], $_POST['payment_method'])) {
    die("Invalid request. Missing customer details.");
}

$customer_name  = htmlspecialchars($_POST['customer_name']);
$mobile_number  = htmlspecialchars($_POST['mobile_number']);
$address        = htmlspecialchars($_POST['address']);
$payment_method = htmlspecialchars($_POST['payment_method']);

// ----------------------------
// 3. Set Order Dates
// ----------------------------
$order_date  = date("Y-m-d"); // today's date
$pickup_date = date("Y-m-d", strtotime("+20 days"));

// ----------------------------
// 4. Insert Order into the ordersss Table
// ----------------------------
$sql = "INSERT INTO ordersss 
    (pet_id, pet_name, pet_price, quantity, total_price, pet_image, customer_name, mobile_number, address, payment_method, order_date, pickup_date)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters: 
// pet_id (i), pet_name (s), pet_price (d), quantity (i), total_price (d),
// pet_image (s), customer_name (s), mobile_number (s), address (s), payment_method (s), order_date (s), pickup_date (s)
$stmt->bind_param("isdiisssssss", 
    $pet_id, 
    $pet_name, 
    $pet_price, 
    $quantity, 
    $total_price, 
    $pet_image, 
    $customer_name, 
    $mobile_number, 
    $address, 
    $payment_method, 
    $order_date, 
    $pickup_date
);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$order_id = $stmt->insert_id;
$stmt->close();
$conn->close();

// Optionally, clear session data after storing the order
// session_unset();
// session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/cart1.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #ff8c00;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            color: black;
            background-image: url('images/finalBack1.jpg');
        }
        .container {
            background: #fff;
            padding: 20px;
            margin: 40px auto;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            text-align: center;
        }
        .image-preview img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .details {
            text-align: left;
            font-size: 16px;
            margin-top: 10px;
        }
        .details p {
            margin: 8px 0;
        }
        .bold {
            font-weight: bold;
        }
        hr {
            border: none;
            height: 1px;
            background: #ddd;
            margin: 15px 0;
        }
        .home-btn {
            display: inline-block;
            background: orange;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
            margin-top: 15px;
        }
        .home-btn:hover {
            background: darkorange;
        }
        footer {
            background-color: #ff8c00;
            text-align: center;
            padding: 1em 0;
            position: fixed;
            width: 100%;
            bottom: 0;
            color: white;
        }
    </style>
</head>
<body>
<header>
    <h1>Order Confirmed</h1>
</header>

<div class="container">
    <h2> Order Confirmed!</h2>
    <p>Thank you for your purchase, <?= htmlspecialchars($customer_name) ?>.</p>

    <div class="image-preview">
        <img src="<?= htmlspecialchars($pet_image) ?>" alt="<?= htmlspecialchars($pet_name) ?>">
    </div>
    <div class="details">
        <p><span class="bold">Pet Name:</span> <?= htmlspecialchars($pet_name) ?></p>
        <p><span class="bold">Price per Pet:</span> ₹<?= number_format($pet_price, 2) ?></p>
        <p><span class="bold">Quantity:</span> <?= htmlspecialchars($quantity) ?></p>
        <p><span class="bold">Total Price:</span> ₹<?= number_format($total_price, 2) ?></p>
        <hr>
        <p><span class="bold">Customer Name:</span> <?= htmlspecialchars($customer_name) ?></p>
        <p><span class="bold">Mobile Number:</span> <?= htmlspecialchars($mobile_number) ?></p>
        <p><span class="bold">Address:</span> <?= htmlspecialchars($address) ?></p>
        <p><span class="bold">Payment Method:</span> <?= htmlspecialchars($payment_method) ?></p>
        <hr>
        <p><strong>Order Date:</strong> <?= date("d/m/Y") ?></p>
        <p><span class="bold">Pickup Date:</span> <?= date("d/m/Y", strtotime("+20 days")) ?></p>
    </div>
    <a href="home.php" class="home-btn">🏠 Return to Home</a>
</div>

<footer>
    <p>&copy; 2024 Glamorous Pet Store. All rights reserved.</p>
</footer>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>
