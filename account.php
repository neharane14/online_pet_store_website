<?php
session_start();
require 'dbConnection.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Retrieve user details
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$mobile = $_SESSION['mobile'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>

    <div class="profile-container">
        <div class="profile-card">
            <img src="images/profile-icon.png" alt="Profile Image" class="profile-img">
            <h2><?= htmlspecialchars($username) ?></h2>
            <p class="email"><?= htmlspecialchars($email) ?></p>

            <button onclick="window.location.href='editAccount.php'" class="edit-btn">Edit Account</button>

            <h3>Welcome, <?= htmlspecialchars($username) ?>!</h3>
           

            <button onclick="window.location.href='home.php'" class="home-btn">Back to Home</button>
            <button onclick="window.location.href='userLogout.php'" class="logout-btn">Logout</button>
        </div>
    </div>

</body>
</html>
