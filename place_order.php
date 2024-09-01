<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    header('Location: login.php?type=customer');
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

    $customer_id = $_SESSION['user_id'];
    $dish_id = $_POST['dish_id'];
    $restaurant_id = $_POST['restaurant_id'];
    $quantity = $_POST['quantity'];

    $sql = "SELECT price FROM dishes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dish_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dish = $result->fetch_assoc();
    $total_price = $dish['price'] * $quantity;

    $sql = "INSERT INTO orders (customer_id, restaurant_id, dish_id, quantity, total_price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiid", $customer_id, $restaurant_id, $dish_id, $quantity, $total_price);

    if ($stmt->execute()) {
        header("Location: ordered.php");
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
    <title>Place Order</title>
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

        form div{
            display: flex;
            gap: 1em;
            margin-bottom: 1em;
        }

        form div input{
            width: 50px;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Place Your Order</h2>
        <form action="place_order.php" method="post">
            <input type="hidden" name="dish_id" value="<?php echo $_GET['dish_id']; ?>">
            <input type="hidden" name="restaurant_id" value="<?php echo $_GET['restaurant_id']; ?>">
            <div>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" min="1" required placeholder="0">
            </div>
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>
