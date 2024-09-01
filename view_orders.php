<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'restaurant') {
    header('Location: login.php?type=restaurant');
    exit();
}

$servername = "localhost";
$username = "root";  // Use your MySQL username
$password = "";      // Use your MySQL password
$dbname = "task5";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$restaurant_id = $_SESSION['user_id'];
$sql = "SELECT o.id, u.username AS customer_name, d.name AS dish_name, o.quantity, o.total_price, o.order_date, o.status 
        FROM orders o 
        JOIN users u ON o.customer_id = u.id 
        JOIN dishes d ON o.dish_id = d.id 
        WHERE o.restaurant_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $restaurant_id);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Orders Placed</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Dish</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['dish_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
