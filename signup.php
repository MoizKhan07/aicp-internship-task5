<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";  // Use your MySQL username
    $password = "";      // Use your MySQL password
    $dbname = "task5";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_type = $_POST['user_type'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (username, password, email, user_type) VALUES ('$username', '$password', '$email', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful! Please wait for admin approval.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         body{
            background-image: url(background.jpg);
            background-size: cover;
            background-position: bottom;
        }
    </style>
</head>
<body>
    <?php
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    if ($type == 'restaurant') {
        echo "<h2>Restaurant Signup</h2>";
    } else {
        echo "<h2>Customer Signup</h2>";
    }
    ?>
    <form action="signup.php" method="post">
        <input type="hidden" name="user_type" value="<?php echo $type; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Sign Up</button>
    </form>

</body>
</html>
