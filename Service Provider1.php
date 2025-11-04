<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="Service Provider.css">
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
    
    <main>
        <marquee id="flashingMarquee">BOOK YOUR SERVICE NOW!! HURRY UP!!</marquee>

    <div class="container">
        <h2>Service Provider Details</h2>
        <div class="details">
            <img src="images/ceo_img.png" alt="Pooja Parab" class="profile-pic">
            <p><strong>Name:</strong> Pooja Parab</p>
            <p><strong>Mobile Number:</strong> +91 9423456789</p>
            <p><strong>Email:</strong> poojaparab123@gmail.com</p>
            <p><strong>Service Type:</strong> Bath</p>
        </div>
        <br>

        <div class="details">
            <img src="images/boi1.webp" alt="Niranjan Rane" class="profile-pic">
            <p><strong>Name:</strong> Niranjan Rane</p>
            <p><strong>Mobile Number:</strong> +91 7865789678</p>
            <p><strong>Email:</strong> nirane123@gamil.com</p>
            <p><strong>Service Type:</strong> Spa</p>
        </div>
        <br>

        <div class="details">
            <img src="images/manager_img.webp" alt="Asha Sawant" class="profile-pic">
            <p><strong>Name:</strong> Asha Sawant</p>
            <p><strong>Mobile Number:</strong> +91 8234567278</p>
            <p><strong>Email:</strong> ashasawant145@gamil.com</p>
            <p><strong>Service Type:</strong> Grooming</p>
        </div>
        <br>

        <div class="details">
            <img src="images/boi2.jpg" alt="Ashutosh Sawant" class="profile-pic">
            <p><strong>Name:</strong> Ashutosh Sawant</p>
            <p><strong>Mobile Number:</strong> +91 8234565678</p>
            <p><strong>Email:</strong> ashusawant149@gamil.com</p>
            <p><strong>Service Type:</strong> Boarding</p>
        </div>
        <br>

        <div class="details">
            <img src="images/boi3.avif" alt="Manoj Dalvi" class="profile-pic">
            <p><strong>Name:</strong> Manoj Dalvi</p>
            <p><strong>Mobile Number:</strong> +91 7423178590</p>
            <p><strong>Email:</strong> manojdalvi145@gamil.com</p>
            <p><strong>Service Type:</strong> Bath</p>
        </div>
        <br>

    </div>
    </main>

    <script src="gallery.js"></script>
    <script src="catGallery.js"></script>

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

     <!--footer section starts-->
     <footer>
        <p>&copy; 2024 Glamorous Pet Store. All rights reserved.</p>
    </footer>
    <!--footer section ends-->

    
</body>
</html>