<?php
session_start();
session_destroy(); // Destroy all sessions
header("Location: admin.html"); // Redirect to admin login page
exit();
?>
