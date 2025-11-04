<?php
require 'dbConnection.php'; // Ensure your database connection file is included properly

// ADD PET
if (isset($_POST['addPet'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $food = $_POST['food'];
    $image = $_FILES['image']['name'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($image);

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

      // Move uploaded file to the target directory
      if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO pets (name, price, image, type, food) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsss", $name, $price, $targetFile, $type, $food);
        
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Pet added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error adding pet: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Error uploading file. Check folder permissions.</p>";
    }

    
     // Redirect to the respective gallery page based on pet type
     if ($type === "cat") {
        header("Location: catGallery.php");
    } else {
        header("Location: dogGallery.php");
    }
    exit(); // Ensure the script stops execution after redirection
        
}

// DELETE PET
if (isset($_POST['deletePet'])) {
    $petId = $_POST['petId'];
    $stmt = $conn->prepare("DELETE FROM pets WHERE id = ?");
    $stmt->bind_param("i", $petId);
    $stmt->execute();
    echo "<p style='color:green;'>Pet deleted successfully!</p>";
}

// FETCH PETS
$pets = $conn->query("SELECT * FROM pets");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pets</title>
    <link rel="stylesheet" href="petsGallery.css">
    <link rel="stylesheet" href="adminPanel.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    color: #333;
        }

        *{
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
    padding: 0;
    margin: 0;
    outline: none; border: none;
    text-decoration: none;
    text-transform: capitalize;
    transition: .2s linear;
    
}


        h1, h2 {
            text-align: center;
        }

        /* Vertical Form Styling */
        form {
            max-width: 450px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, button {
            width: 400px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            width: 90px;
        }

        button:hover {
            background-color: #218838;
        }

        /* Vertical Styling */
    .pet-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(25rem, auto));
    gap: 2rem;
    width: 100%;
    height: 100%;
    align-items: center;
}

.pet-card {
    padding: 3rem;
    text-align: center;
    border: var(--border);
    border: 2px solid #4caf50;
    width: 100%;
    margin: 20px auto;
    height: 100%;
    padding: 20px;
    gap: 2rem;
    margin-top: 4rem;
}

.pet-card img {
    height: 10rem;
}

.pet-card h1 {
    font-size: 1rem;
    padding: 1rem 0;
    color: black;
}

.pet-card p {
    font-size: 1rem;
    padding: .5rem 0;
}

.pet-card span {
    font-size: 1.5rem;
    text-decoration: line-through;
}

.pet-container .pet-card:hover {
    background: #fff;
}

.pet-container .pet-card:hover >* {
    color: var(--black);
}



    </style>
</head>
<body>

    <h1>Add Pets</h1>

    <!-- ADD PET FORM -->
    <form action="managePets.php" method="POST" enctype="multipart/form-data">
        <label for="name">Pet Name:</label>
        <input type="text" name="name" required>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required>

        <label for="type">Pet Type:</label>
        <select name="type" required>
            <option value="cat">Cat</option>
            <option value="dog">Dog</option>
        </select>

        <label for="food">Pet Food:</label>
        <input type="text" name="food" required>

        <label for="image">Pet Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" name="addPet">Add Pet</button>
    </form>

    <hr>

  <!-- DISPLAY PETS LIST IN VERTICAL FORMAT -->
<h2>Pets Added</h2>
<div class="pet-container">
    <?php while ($pet = $pets->fetch_assoc()) { ?>
        <div class="pet-card">
            <img src="<?= $pet['image'] ?>" alt="<?= $pet['name'] ?>">
            <h1><p>Name:<?= $pet['name'] ?></p></h1>
            <p>Price: <?= number_format($pet['price'], 2) ?> <h3></h3></p>
            <h3><p>Suggested Food: <?= $pet['food'] ?></p></h3>
            <form method="POST" action="managePets.php">
                <input type="hidden" name="petId" value="<?= $pet['id'] ?>">
                <button type="submit" name="deletePet" onclick="return confirm('Are you sure?')">Delete</button>
                <a href="editPet.php?petId=<?= $pet['id'] ?>" style="text-decoration: none;">
    <button type="button">Edit</button>
</a>

            </form>
        </div>
    <?php } ?>
</div>


</body>
</html>
