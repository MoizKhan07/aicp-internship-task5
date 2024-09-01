<?php
session_start();

// Check if user is logged in and is of type 'customer'
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    header('Location: login.php?type=customer');
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";  // Use your MySQL username
$password = "";      // Use your MySQL password
$dbname = "task5";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for any connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Modify the SQL query to select all fields including the new ones
$sql = "SELECT id, name, address, phone, email, city, state, zip_code, country, cuisine_type, opening_hours, rating, price_range, website_url FROM restaurants";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Restaurants</title>
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

        .container {
            width: 80%;
            max-width: 900px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #4cae4c;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: left;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 3em;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        li:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .restaurant-info {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .info-section {
            flex: 1;
            min-width: 200px;
        }

        .info-section strong {
            display: block;
            margin-bottom: 5px;
            color: #4cae4c;
        }

        .restaurant-name {
            font-size: 1.5em;
            color: #4cae4c;
            margin-bottom: 10px;
        }

        a.view-dishes {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            text-decoration: none;
            color: #fff;
            background-color: #4cae4c;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            align-self: flex-start;
        }

        a.view-dishes:hover {
            background-color: white;
            border: 1px solid #4cae4c;
            color: #4cae4c;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Available Restaurants</h2>
        <ul>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li>
                    <h3 class="restaurant-name"><?php echo htmlspecialchars($row['name']); ?></h3>
                    <div class="restaurant-info">
                        <div class="info-section">
                            <strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?>, <?php echo htmlspecialchars($row['city']); ?>, <?php echo htmlspecialchars($row['state']); ?> <?php echo htmlspecialchars($row['zip_code']); ?>, <?php echo htmlspecialchars($row['country']); ?>
                        </div>
                        <div class="info-section">
                            <strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?>
                        </div>
                        <div class="info-section">
                            <strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?>
                        </div>
                        <div class="info-section">
                            <strong>Cuisine Type:</strong> <?php echo htmlspecialchars($row['cuisine_type']); ?>
                        </div>
                        <div class="info-section">
                            <strong>Opening Hours:</strong> <?php echo htmlspecialchars($row['opening_hours']); ?>
                        </div>
                        <div class="info-section">
                            <strong>Rating:</strong> <?php echo htmlspecialchars($row['rating']); ?>
                        </div>
                        <div class="info-section">
                            <strong>Price Range:</strong> <?php echo htmlspecialchars($row['price_range']); ?>
                        </div>
                        <div class="info-section">
                            <strong>Website:</strong> <a href="<?php echo htmlspecialchars($row['website_url']); ?>" target="_blank"><?php echo htmlspecialchars($row['website_url']); ?></a>
                        </div>
                    </div>
                    <a href="view_dishes.php?restaurant_id=<?php echo urlencode($row['id']); ?>" class="view-dishes">View Dishes</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
