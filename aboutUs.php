<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Pet Store</title>
    <link rel="stylesheet" href="aboutUs.css">
</head>
<body>
    <!--Header section starts-->
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
                
            </ul>
        </nav>
    </header>
    <!--Header section ends-->

    <!--About section starts-->
    <section class="about" id="about">
 
        <div class="image">
            <img src="images/cat_dog_back.jpg" alt="">
        </div>

        <div class="content">
            <h3>We Keep <span>Pet</span> For Pleasure</h3>
            <p>We're pet owners , just like you. We know what it's like to love pets and what the best for them. That's why we started <b>"Glamorous Pet Store" </b>to make sure that every food product we suggested is high-quality, natural, and safe for pets.</p>
        </div>
    
    </section> 

    <section class="testimonials">
        <h2>What Our Customers Say</h2>
        <div class="testimonial">
            <p>"Great service and amazing suggested food products for my pets!"</p>
            <span>- Rajashree Marathe</span>
        </div>
        <div class="testimonial">
            <p>"The staff is so helpful and friendly!"</p>
            <span>- Shyam Sawant</span>
        </div>
    </section>
    
    <!--About section ends-->

    
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
    <script src="about us.js"></script>
    <script src="gallery.js"></script>
    <script src="catGallery.js"></script>
    
    <footer>
        <p>&copy; 2024 Glamorous Pet Store. All rights reserved.</p>
    </footer>
</body>
</html>
