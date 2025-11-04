<?php
require 'dbConnection.php';
ob_start(); // Start output buffering

// Check if petId is passed in the URL
if (isset($_GET['petId'])) {
    $petId = $_GET['petId'];

    // Fetch the pet details
    $stmt = $conn->prepare("SELECT * FROM pets WHERE id = ?");
    $stmt->bind_param("i", $petId);
    $stmt->execute();
    $result = $stmt->get_result();
    $pet = $result->fetch_assoc();

    if (!$pet) {
        die("<p style='color:red;'>Pet not found!</p>");
    }
} else {
    die("<p style='color:red;'>Invalid request!</p>");
}

// Handle pet update
if (isset($_POST['updatePet'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $food = $_POST['food'];
    $image = $_FILES['image']['name'];

    // If a new image is uploaded
    if (!empty($image)) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    } else {
        $targetFile = $pet['image']; // Keep existing image
    }

    // Update pet details
    $stmt = $conn->prepare("UPDATE pets SET name=?, price=?, type=?, food=?, image=? WHERE id=?");
    $stmt->bind_param("sdsssi", $name, $price, $type, $food, $targetFile, $petId);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Pet updated successfully!</p>";
        
        // Ensure output buffer is cleaned before redirection
        ob_clean();
        
         // Redirect to the correct gallery page
    if ($type === "cat") {
        header("Location: catGallery.php");
    } else {
        header("Location: dogGallery.php"); // Redirect dogs to dogGallery.php
    }
    exit(); // Stop script execution after redirection
}
}

ob_end_flush(); // End output buffering
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet</title>
</head>
<body>

    <h1>Edit Pet</h1>

    <form action="editPet.php?petId=<?= $petId ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Pet Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($pet['name']) ?>" required>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($pet['price']) ?>" required>

        <label for="type">Pet Type:</label>
        <select name="type" required>
            <option value="cat" <?= $pet['type'] === 'cat' ? 'selected' : '' ?>>Cat</option>
            <option value="dog" <?= $pet['type'] === 'dog' ? 'selected' : '' ?>>Dog</option>
        </select>

        <label for="food">Pet Food:</label>
        <input type="text" name="food" value="<?= htmlspecialchars($pet['food']) ?>" required>

        <label for="image">Pet Image:</label>
        <input type="file" name="image" accept="image/*">
        <p>Current Image:</p>
        <img src="<?= htmlspecialchars($pet['image']) ?>" alt="Pet Image" width="100">

        <button type="submit" name="updatePet">Update Pet</button>
    </form>

    <style>
        /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    flex-direction: column;
}

/* Heading */
h1 {
    text-align: center;
    color: #28a745;
    margin-bottom: 20px;
}

/* Form Styles */
form {
    background: white;
    max-width: 400px;
    width: 100%;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Label Styles */
label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
}

/* Input Fields */
input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

/* File Input */
input[type="file"] {
    padding: 5px;
}

/* Image Preview */
img {
    display: block;
    margin: 10px auto;
    border-radius: 5px;
    width: 100px;
    height: auto;
    border: 2px solid #28a745;
}

/* Button */
button {
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border-radius: 5px;
    transition: 0.3s;
}

button:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 500px) {
    form {
        max-width: 90%;
    }
}

    </style>

</body>
</html>
