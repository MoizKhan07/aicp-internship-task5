<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    header('Location: login.php?type=customer');
    exit();
}

$restaurant_id = $_GET['restaurant_id'];

$servername = "localhost";
$username = "root";  // Use your MySQL username
$password = "";      // Use your MySQL password
$dbname = "task5";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, description, price FROM dishes WHERE restaurant_id = ? AND available = 1";
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
    <title>View Dishes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Dishes Available</h2>
        <table>
            <tr>
                <th>Dish Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><a href="place_order.php?dish_id=<?php echo $row['id']; ?>&restaurant_id=<?php echo $restaurant_id; ?>">Order</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
