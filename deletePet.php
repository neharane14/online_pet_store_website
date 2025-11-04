<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petstore2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the pet by ID
$id = $_GET['id'];
$sql = "DELETE FROM pets WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Pet deleted successfully!";
} else {
    echo "Error deleting pet: " . $conn->error;
}

$conn->close();
?>
