<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "petstore2";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get new values from the form
$newUsername = $_POST['username'];
$newEmail = $_POST['email'];
$newMobile = $_POST['mobile'];
$currentUsername = $_SESSION['username'];

// Update the database
$stmt = $conn->prepare("UPDATE registration SET username = ?, email = ?, mobile = ? WHERE username = ?");
$stmt->bind_param("ssss", $newUsername, $newEmail, $newMobile, $currentUsername);

if ($stmt->execute()) {
    // Update session variables
    $_SESSION['username'] = $newUsername;
    $_SESSION['email'] = $newEmail;
    $_SESSION['mobile'] = $newMobile;

    echo "<script>
            alert('Account updated successfully!');
            window.location.href = 'account.php';
          </script>";
} else {
    echo "<script>
            alert('Error updating account.');
            window.location.href = 'editAccount.php';
          </script>";
}

$stmt->close();
$conn->close();
?>
