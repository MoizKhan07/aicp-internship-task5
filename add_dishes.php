<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'restaurant') {
    header('Location: login.php?type=restaurant');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";  // Use your MySQL username
    $password = "";      // Use your MySQL password
    $dbname = "task5";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $restaurant_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO dishes (restaurant_id, name, description, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issd", $restaurant_id, $name, $description, $price);

    if ($stmt->execute()) {
        echo "Dish added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Dish</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('admin-bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container{
            background-color: rgba(255, 255, 255, 0);
        }
        h2{
            color:  white;
            text-shadow: 1px 1px 10px black;
        }

        form{
            margin: 0 auto;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Add a New Dish</h2>
        <form action="add_dishes.php" method="post">
            <label for="name">Dish Name:</label>
            <input type="text" name="name" required>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea>
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" required>
            <button type="submit" style="margin-top: 1em;">Add Dish</button>
        </form>
    </div>
</body>
</html>
