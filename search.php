<?php
require 'dbConnection.php';

// Determine the pet type based on the referring page
$petType = ''; // Default empty

if (isset($_SERVER['HTTP_REFERER'])) {
    if (strpos($_SERVER['HTTP_REFERER'], 'catGallery.html') !== false) {
        $petType = 'cat';
    } elseif (strpos($_SERVER['HTTP_REFERER'], 'gallery.html') !== false) {
        $petType = 'dog';
    }
}

// Check if a search query is provided
if (isset($_GET['query'])) {
    $searchQuery = $conn->real_escape_string($_GET['query']);

    // If pet type is determined, filter by name and type
    if ($petType) {
        $result = $conn->query("SELECT * FROM pets WHERE type='$petType' AND name LIKE '%$searchQuery%'");
    } else {
        $result = $conn->query("SELECT * FROM pets WHERE name LIKE '%$searchQuery%'");
    }
} else {
    // Default query (show all pets based on type)
    if ($petType) {
        $result = $conn->query("SELECT * FROM pets WHERE type='$petType'");
    } else {
        $result = $conn->query("SELECT * FROM pets");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome To Our Pet Store</title>
    <link rel="stylesheet" href="petsGallery.css">
    <link rel="stylesheet" href="catGallery.css">
</head>
<body>

<header>
    <h1>Search Results</h1>
    <nav class="navbar">
        <img src="images/mainLogo.jpeg" class="logo"> 
        <ul>
            <li><a href="home.php"><b>Home</b></a></li>
            <li><a href="aboutUs.php"><b>About Us</b></a></li>
            <li><a href="contactus1.php"><b>Contact Us</b></a></li>
            <li><a href="pet1.php"><b>Pet</b></a></li>
            <li><a href="Service Provider1.php"><b>Service Provider</b></a></li>
           

            <?php if (isset($_SESSION['username'])): ?>
                <li>
                <a href="account.php" class="username-link">
                <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>
                </a>
                </li>
                <?php else: ?>
                <li><a href="login.html"><b>Login</b></a></li>
                <?php endif; ?>

                <div class="icon-row">
                    <a href="admin.html" title="Admin">
                      <img src="images/user.png" alt="Admin" class="icon">
                    </a>
                    <a href="cart.php" title="Cart" class="cart-container">
    <img src="images/cart.png" alt="Cart" class="icon">
    <span class="cart-counter">
        <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
    </span>
</a>

       <!-- Search Bar -->
       <form action="search.php" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Search Pets..." required>
                </form>
        </ul>
    </nav>
</header>

<h1>Search Results for "<?= htmlspecialchars($_GET['query'] ?? '') ?>"</h1>

<div class="pet-container">
    <?php if ($result->num_rows > 0) { ?>
        <?php while ($pet = $result->fetch_assoc()) { ?>
            <div class="pet-card">
                <img src="<?= $pet['image'] ?>" alt="<?= $pet['name'] ?>">
                <h2>Name: <?= $pet['name'] ?></h2>
                <h2><p>Price: <?= number_format($pet['price'], 2) ?></h2></p>
                <h2><p>Suggested Food:</h2> <?= $pet['food'] ?></p>
                <button class="add-to-cart" onclick="window.location.href='cart.php?id=<?= $pet['id'] ?>&name=<?= urlencode($pet['name']) ?>&price=<?= $pet['price'] ?>&image=<?= urlencode($pet['image']) ?>'">Add to Cart</button>
                <button class="buy-now" onclick="window.location.href='buyNow.php?id=<?= $pet['id'] ?>&name=<?= urlencode($pet['name']) ?>&price=<?= $pet['price'] ?>&image=<?= urlencode($pet['image']) ?>'">Buy Now</button>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No pets found matching your search.</p>
    <?php } ?>
</div>

<footer>
    <p>&copy; 2024 Glamorous Pet Store. All rights reserved.</p>
</footer>

</body>
</html>
