<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect if not logged in
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

// Fetch current user details
$stmt = $conn->prepare("SELECT username, email, mobile FROM registration WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>
    <div class="container">
        <h1>Edit Account</h1>
        <form action="updateAccount.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="mobile">Mobile:</label>
            <input type="text" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>

            <button type="submit">Update Account</button>
        </form>
        <a href="account.php">Back to My Account</a>
    </div>
</body>
</html>
