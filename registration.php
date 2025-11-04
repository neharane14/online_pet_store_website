<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "petstore2"; // Replace with your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $username = $_POST['unm'];
    $mobile = $_POST['pn'];
    $email = $_POST['em'];
    $password = $_POST['pass'];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare SQL statement to insert user data
    //$sql = "INSERT INTO registration (name, usernames, phone, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare("INSERT INTO registration (username, mobile, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $username, $mobile, $email, $hashedPassword);



    // Execute and check for success
    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Login now.');
                window.location.href = 'login.html'; // Redirect to login page
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>