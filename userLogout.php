<?php
session_start();
session_destroy(); // Destroy all sessions
header("Location: home.php"); // Redirect to admin login page
exit();
?>
