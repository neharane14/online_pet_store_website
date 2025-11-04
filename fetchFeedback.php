<?php
include 'dbConnection.php';

$sql = "SELECT id, name, email, mobile, message, submitted_at FROM contactus ORDER BY submitted_at ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3>Customer Feedback</h3>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Message</th>
                <th>Date</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td> <!-- Displaying ID column -->
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['mobile']}</td>
                <td>{$row['message']}</td>
                <td>{$row['submitted_at']}</td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "<p>No feedback available.</p>";
}

$conn->close();
?>

<head>
  
    <link rel="stylesheet" href="adminPanel.css">
    <style>   
    h1,h3 {
            text-align: center;
        }

        /* Table Header */
th {
    background-color: #f38232;
    color: white;
    padding: 12px;
    text-align: left;
    font-size: 16px;
}
    </style>
</head>
