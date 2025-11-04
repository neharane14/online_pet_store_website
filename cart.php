<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding pets to cart
if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['price']) && isset($_GET['image'])) {
    $id = $_GET['id'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $image = $_GET['image'];

    // Check if the item is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] += 1; // Increase quantity
            $found = true;
            break;
        }
    }

    // If not found, add a new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => 1
        ];
    }

    // Redirect back to cart
    header("Location: cart.php");
    exit();
}

// Handle quantity increase
if (isset($_GET['increase'])) {
    $increaseId = $_GET['increase'];
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $increaseId) {
            $item['quantity'] += 1;
            break;
        }
    }
    echo json_encode(["success" => true]);
    exit();
}

// Handle quantity decrease
if (isset($_GET['decrease'])) {
    $decreaseId = $_GET['decrease'];
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $decreaseId) {
            if ($item['quantity'] > 1) {
                $item['quantity'] -= 1;
            } else {
                unset($_SESSION['cart'][array_search($item, $_SESSION['cart'])]); // Remove if quantity reaches 0
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
            break;
        }
    }
    echo json_encode(["success" => true]);
    exit();
}

// Remove an item from the cart
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $removeId) {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
}

// Calculate total price
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .user-container {
            position: relative;
            display: inline-block;
        }

        .user-box {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 150px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 6px;
        }

        .dropdown-menu li {
            list-style: none;
        }

        .dropdown-menu li a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #000;
        }

        .dropdown-menu li a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to Our Pet Store</h1>
    <nav class="navbar">
        <img src="images/mainLogo.jpeg" class="logo">
        <ul>
            <li><a href="home.php"><b>Home</b></a></li>
            <li><a href="aboutUs.php"><b>About Us</b></a></li>
            <li><a href="contactus1.php"><b>Contact Us</b></a></li>
            <li><a href="pet1.php"><b>Pet</b></a></li>
            <li><a href="Service Provider1.php"><b>Service Provider</b></a></li>

            <div class="icon-row">
                <a href="cart.php" title="Cart" class="cart-container">
                    <img src="images/cart.png" alt="Cart" class="icon">
                    <span class="cart-counter">
                        <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                    </span>
                </a>

                <div class="user-container">
                    <div class="user-box" id="userIcon">
                        <img src="images/user.png" alt="User" class="icon">
                        <?php if (isset($_SESSION['username'])): ?>
                            <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['username'])): ?>
                        <ul class="dropdown-menu" id="dropdownMenu">
                            <li><a href="account.php">My Account</a></li>
                            <li><a href="order.php">My Orders</a></li>
                            <li><a href="userLogout.php">Logout</a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </ul>
    </nav>
</header>

<h3>Your Shopping Cart</h3>
<div class="cart-section">
  <div class="cart-box">
    <?php if (!empty($_SESSION['cart'])): ?>
        <?php foreach ($_SESSION['cart'] as $item): ?>
        <div class="cart-item">
            <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="cart-img">
            <div class="cart-details">
                <h2><?= $item['name'] ?></h2>
                <p>Price: <?= number_format($item['price'], 2) ?></p>
                <div class="quantity-controls">
                    <button class="decrease-qty" data-id="<?= $item['id'] ?>">-</button>
                    <span class="quantity" id="qty-<?= $item['id'] ?>"><?= $item['quantity'] ?></span>
                    <button class="increase-qty" data-id="<?= $item['id'] ?>">+</button>
                </div>
                <p>Total: <span class="total-price" id="total-<?= $item['id'] ?>"><?= number_format($item['price'] * $item['quantity'], 2) ?></span></p>
            </div>
            <a href="cart.php?remove=<?= $item['id'] ?>" class="remove-btn">Remove</a>
            <a href="orderForm.php?id=<?= $item['id'] ?>&name=<?= urlencode($item['name']) ?>&price=<?= $item['price'] ?>&image=<?= urlencode($item['image']) ?>&quantity=<?= $item['quantity'] ?>" class="checkout-btn">Checkout</a>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>
    </div>

<footer>
    <p>&copy; 2024 Glamorous Pet Store. All rights reserved.</p>
</footer>

<script>
$(document).ready(function() {
    $(".increase-qty").click(function() {
        var petId = $(this).data("id");
        $.get("cart.php", { increase: petId }, function(response) {
            location.reload();
        });
    });

    $(".decrease-qty").click(function() {
        var petId = $(this).data("id");
        $.get("cart.php", { decrease: petId }, function(response) {
            location.reload();
        });
    });

    $(".remove-btn").click(function() {
        setTimeout(updateCartCounter, 500);
    });

    function updateCartCounter() {
        $.get("cartCounter.php", function(response) {
            $(".cart-counter").text(response);
            $(".cart-counter").css("display", response > 0 ? "flex" : "none");
        });
    }

    updateCartCounter();

    $(".add-to-cart").click(function(event) {
        event.preventDefault();
        var url = $(this).attr("onclick").match(/'(.*?)'/)[1];
        $.get(url, function(response) {
            updateCartCounter();
            window.location.href = "cart.php";
        });
    });

    $("#userIcon").click(function(e) {
        e.stopPropagation();
        $("#dropdownMenu").toggleClass("show");
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('.user-container').length) {
            $("#dropdownMenu").removeClass("show");
        }
    });
});
</script>

</body>
</html>