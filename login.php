<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "petstore2";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['unm'];
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT username, email, mobile, password FROM registration WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['mobile'] = $row['mobile'];

            header("Location: home.php"); // Redirect to homepage after login
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('No user found with that username. Please register.'); window.location.href='registration.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
