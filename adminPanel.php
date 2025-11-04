<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="adminPanel.css">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <h2>Admin Dashboard</h2>
            <nav>
                <ul>
                    <li><a href="managePets.php">Manage Pets</a></li>
                    <li><a href="manageUsers.php">Manage Users</a></li>
                    <li><a href="manageOrders.php">Manage Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <main class="content">
            <h1>Welcome, <?= $_SESSION['admin'] ?>!</h1>
            <p>Select an option from the sidebar.</p>
        </main>
    </div>
</body>
</html>
