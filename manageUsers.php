<?php
require 'dbConnection.php';

// DELETE USER FUNCTIONALITY
if (isset($_POST['deleteUser'])) {
    $userId = $_POST['userId'];
    $stmt = $conn->prepare("DELETE FROM registration WHERE uid = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    echo "<script>alert('User deleted successfully!');</script>";
}

// FETCH USERS
$users = $conn->query("SELECT * FROM registration");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="adminPanel.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
            background-color: #ff8c00;
            color: white;
        }


        h1 {
            text-align: center;
        }

        button {
            padding: 5px 10px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Register Users</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Mobile</th>
            <th>Email</th>
            
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $users->fetch_assoc()) { ?>
            <tr>
                <td><?= $user['uid'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['mobile'] ?></td>
                <td><?= $user['email'] ?></td>
                
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
