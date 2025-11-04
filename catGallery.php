<?php
session_start();
?>

<?php
require 'dbConnection.php';
$pets = $conn->query("SELECT * FROM pets WHERE type='cat'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cat Gallery</title>
    <link rel="stylesheet" href="petsGallery.css">
    <link rel="stylesheet" href="catGallery.css">
</head>

<body>

    <!--Header section starts-->
    <header>
        <h1>Welcome to Our Pet Store</h1>
        <nav class="navbar">
            <img src="images/mainLogo.jpeg" class="logo"> 
            <ul>
                <li><a href="home.php"><b>Home</b></a></li>
                <li><a href="aboutUs.php"><b>About Us</b></a></a></li>
                <li><a href="contactus1.php"><b>Contact Us</b></a></li>
                <li><a href="pet1.php"><b>Pet</b></a></li>
                <li><a href="Service Provider1.php"><b>Service Provider</b></a></li>
              
                <div class="icon-row">
                 <!-- Search Bar -->
                 <form action="search.php" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Search Pets..." required>
                </form>
                
                <a href="cart.php" title="Cart" class="cart-container">
                        <img src="images/cart.png" alt="Cart" class="icon">
                        <span class="cart-counter">
                            <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                        </span>
                    </a>

                    <div class="user-container">
    <div class="user-box">
        <img src="images/user.png" alt="User" class="icon" id="userIcon">
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
    <?php else: ?>
        <script>
            document.getElementById("userIcon").addEventListener("click", function() {
                window.location.href = "login.html"; // Redirect if not logged in
            });
        </script>
    <?php endif; ?>
</div>
                </div>

            </ul>
        </nav>
    </header>
    <!--Header section ends-->


     <!--footer section starts-->
     <footer>
        <p>&copy; 2024 Glamorous Pet Store. All rights reserved.</p>
    </footer>
    <!--footer section ends-->

    
<h1>Cat Gallery</h1>

<div class="pet-container">
    <?php while ($pet = $pets->fetch_assoc()) { ?>
        <div class="pet-card">
            <img src="<?= $pet['image'] ?>" alt="<?= $pet['name'] ?>">
            <h2>Name: <?= $pet['name'] ?></h2>
            <h2><p>Price: <?= number_format($pet['price'], 2) ?></h2></p>
            <h2><p>Suggested Food:</h2> <?= $pet['food'] ?></p>
            <!-- Add to Cart and Buy Now buttons -->
            <button class="add-to-cart" onclick="window.location.href='cart.php?id=<?= $pet['id'] ?>&name=<?= urlencode($pet['name']) ?>&price=<?= $pet['price'] ?>&image=<?= urlencode($pet['image']) ?>'">Add to Cart</button>
            <button class="buy-now" onclick="window.location.href='buyNow.php?id=<?= $pet['id'] ?>&name=<?= urlencode($pet['name']) ?>&price=<?= $pet['price'] ?>&image=<?= urlencode($pet['image']) ?>'">Buy Now</button>
        </div>
    <?php } ?>
</div>



<script>
   document.addEventListener("DOMContentLoaded", function () {
    let userIcon = document.getElementById("userIcon");
    let dropdownMenu = document.getElementById("dropdownMenu");
    let username = document.querySelector(".username");

    // Check if user is logged in
    let isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;

    if (isLoggedIn) {
        userIcon.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents closing immediately
            dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (!userIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = "none";
            }
        });
    }
});

    </script>

</body>
</html>
