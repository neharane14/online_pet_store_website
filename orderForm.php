<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['mobile'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Check if GET parameters exist (from buyNow.php)
if (!isset($_GET['id'], $_GET['name'], $_GET['price'], $_GET['image'], $_GET['quantity'])) {
    die("Invalid request. Missing parameters.");
}

// Store pet details in session
$_SESSION['pet_id'] = $_GET['id'];
$_SESSION['pet_name'] = $_GET['name'];
$_SESSION['pet_price'] = floatval($_GET['price']);
$_SESSION['pet_image'] = $_GET['image'];
$_SESSION['pet_quantity'] = intval($_GET['quantity']);
$_SESSION['total_price'] = $_SESSION['pet_price'] * $_SESSION['pet_quantity'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Complete Your Order</h1>
</header>

<div class="container">
    <div class="image-preview">
        <img src="<?= htmlspecialchars($_SESSION['pet_image']) ?>" alt="<?= htmlspecialchars($_SESSION['pet_name']) ?>">
    </div>

    <form action="orderConfirmation.php" method="post">
        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>

        <label>Mobile Number:</label>
        <input type="tel" name="mobile_number" value="<?= htmlspecialchars($_SESSION['mobile']) ?>" required>

        <label>Address:</label>
        <input type="text" name="address" required>

        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="cash_on_delivery">Cash on Delivery</option>
        </select>

        <!-- Hidden fields to pass data -->
        <input type="hidden" name="pet_name" value="<?= htmlspecialchars($_SESSION['pet_name']) ?>">
        <input type="hidden" name="pet_price" value="<?= $_SESSION['pet_price'] ?>">
        <input type="hidden" name="pet_quantity" value="<?= $_SESSION['pet_quantity'] ?>">
        <input type="hidden" name="pet_image" value="<?= htmlspecialchars($_SESSION['pet_image']) ?>">
        <input type="hidden" name="total_price" value="<?= $_SESSION['total_price'] ?>">

        <button type="submit" class="order-btn">Place Order</button>
    </form>
</div>

<style>
    /* Reset default styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Body styling */
body {
  font-family: Arial, sans-serif;
  background: url('images/cart1.jpg') no-repeat center center fixed;
  background-size: cover;
  color: #333;
}

/* Header styling */
header {
  background-color: #ff8c00;
  background-image: url('images/finalBack1.jpg');
  text-align: center;
  padding: 20px 0;
  width: 100%;
}

/* Container for the order form */
.container {
  background: #fff;
  padding: 20px;
  margin: 40px auto;
  max-width: 400px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

}

/* Form heading */
.container h2 {
  margin-bottom: 20px;
  font-size: 24px;
}

/* Form labels */
label {
  display: block;
  font-weight: bold;
  margin-top: 10px;
}

/* Input, select, and textarea styling */
input[type="text"],
input[type="tel"],
textarea,
select {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

/* Order button styling */
.order-btn {
  width: 100%;
  background: green;
  color: white;
  padding: 10px;
  border: none;
  margin-top: 15px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.order-btn:hover {
  background: darkgreen;
}

/* Image preview styling */
.image-preview {
  text-align: center;
  margin-bottom: 20px;
}

.image-preview img {
  width: 100%;
  max-height: 100px;
  object-fit: contain;
  border-radius: 5px;
}

/* Footer styling */
footer {
  background-color: #ff8c00;
  color: white;
  text-align: center;
  padding: 1em 0;
  position: fixed;
  width: 100%;
  bottom: 0;
}

    </style>
    
<footer>
    <p>&copy; 2024 Glamorous Pet Store. All rights reserved.</p>
</footer>

</body>
</html>
