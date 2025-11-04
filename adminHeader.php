<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin.php");
    exit;
}
?>
<aside class="sidebar">
    <h2>Admin Dashboard</h2>
    <nav>
        <ul>
            <li><a href="adminPanel.php">Dashboard</a></li>
            <li><a href="managePets.php">Manage Pets</a></li>
            <li><a href="manageUsers.php">Manage Users</a></li>
            <li><a href="manageOrders.php">Manage Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</aside>
