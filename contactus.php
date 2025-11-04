<?php
include 'dbConnection.php'; // Ensure this file contains your DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim(htmlspecialchars($_POST['nm']));
    $email = trim(htmlspecialchars($_POST['em']));
    $mobile = trim(htmlspecialchars($_POST['pn']));
    $message = trim(htmlspecialchars($_POST['mess']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit;
    }

    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        echo "<script>alert('Invalid mobile number. Please enter 10 digits.'); window.history.back();</script>";
        exit;
    }

    if (empty($name) || empty($message)) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO contactus (name, email, mobile, message) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssis", $name, $email, $mobile, $message);

    if ($stmt->execute()) {
        echo "<script>
                alert('Your message has been sent successfully!');
                window.location.href = 'contactus.html';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
