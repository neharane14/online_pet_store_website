<?php
session_start();

// Check if GET parameters exist
if (!isset($_GET['id'], $_GET['name'], $_GET['price'], $_GET['image'])) {
    die("Invalid request. Missing parameters.");
}

// Retrieve from GET
$pet_id = $_GET['id'];
$pet_name = $_GET['name'];
$pet_price = floatval(str_replace(',', '', $_GET['price']));
$pet_image = $_GET['image'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Buy Now</title>
    <link rel="stylesheet" href="styles.css">
    <script>
       function updateTotal() {
           let price = parseFloat(document.getElementById('price').value.replace(/,/g, ''));
           let quantity = parseInt(document.getElementById('quantity').value);
           let total = price * quantity;
           document.getElementById('total-price').value = total.toFixed(2);
       }
       function goToOrderForm() {
           let quantity = document.getElementById('quantity').value;
           let name = encodeURIComponent("<?= $pet_name ?>");
           let price = "<?= $pet_price ?>";
           let image = encodeURIComponent("<?= $pet_image ?>");
           window.location.href = `orderForm.php?id=<?= $pet_id ?>&name=${name}&price=${price}&image=${image}&quantity=${quantity}`;
       }
    </script>
</head>
<body>

<header>
    <h1>Confirm Your Order</h1>
</header>

<div class="container">
    

    <div class="image-preview">
        <img src="<?= htmlspecialchars($pet_image) ?>" alt="<?= htmlspecialchars($pet_name) ?>">
    </div>

    <label>Pet Name:</label>
    <input type="text" id="petName" value="<?= htmlspecialchars($pet_name) ?>" readonly>

    <label>Price:</label>
    <input type="text" id="price" value="<?= number_format($pet_price, 2) ?>" readonly>

    <label>Quantity:</label>
    <input type="number" id="quantity" value="1" min="1" onchange="updateTotal()">

    <label>Total Price:</label>
    <input type="text" id="total-price" value="<?= number_format($pet_price, 2) ?>" readonly>

    <button class="checkout-btn" onclick="goToOrderForm()">Checkout</button>
</div>

<style>
    /* Reset some basic styles */
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
  padding: 3rem 0;
  width: 100%;
}

/* Container for the buy now content */
.container {
  background: #fff;
  padding: 20px;
  width: 350px;
  margin: 20px auto;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
  border-radius: 8px;
 
}

/* Headings */
.container h2 {
  margin-bottom: 20px;
  font-size: 24px;
}

/* Form labels */
label {
  font-weight: bold;
  display: block;
  margin: 10px 0 5px;
}

/* Input fields */
input[type="text"],
input[type="number"] {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

/* Image preview */
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

/* Checkout button */
.checkout-btn {
  background: green;
  color: white;
  padding: 10px;
  width: 100%;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  margin-top: 15px;
  transition: background 0.3s ease;
}

.checkout-btn:hover {
  background: darkgreen;
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

<?php


// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page
    exit();
}

// Check if GET parameters exist
if (!isset($_GET['id'], $_GET['name'], $_GET['price'], $_GET['image'])) {
    die("Invalid request. Missing parameters.");
}

// Retrieve from GET
$pet_id = $_GET['id'];
$pet_name = $_GET['name'];
$pet_price = floatval(str_replace(',', '', $_GET['price']));
$pet_image = $_GET['image'];
?>



<script>
   function checkLoginAndProceed() {
       let isLoggedIn = "<?= isset($_SESSION['username']) ? 'true' : 'false' ?>";
       
       if (isLoggedIn === "false") {
           alert("You must log in first to place an order.");
           window.location.href = "login.html"; // Redirect to login page
       } else {
           goToOrderForm(); // Proceed to order if logged in
       }
   }
</script>
