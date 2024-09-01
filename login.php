<?php
session_start();

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
    $password = $_POST['password'];

    if ($user_type == 'admin') {
        $sql = "SELECT * FROM admins WHERE username='$username'";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username' AND user_type='$user_type' AND is_approved=1";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['user_id'] = $user_id;
            echo "Login successful!";
            if ($user_type == 'admin') {
                header("Location: admin_panel.php");
            } else if($user_type == 'restaurant'){
                header("Location: restaurant_home.php");
            }else if($user_type == 'customer'){
                header("Location: customer_home.php");
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found or account not approved.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         body{
            background-image: url(background.jpg);
            background-size: cover;
            background-position: bottom;
        }
        a{
            background-color: #4cae4c;
            color: white;
            padding: .5em 1em;
            width: 200px;
            text-align: center;
            border-radius: 2px;
            margin: 0 1em;
            transition: ease .7s;
        }

        a:hover{
            background-color: white;
            border: 1px solid #4cae4c;
            color: #4cae4c;
        }
    </style>
</head>
<body>
    <?php
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    if ($type == 'restaurant') {
        echo "<h2>Restaurant Login</h2>";
    } elseif ($type == 'customer') {
        echo "<h2>Customer Login</h2>";
    } else {
        echo "<h2>Admin Login</h2>";
    }
    ?>

    <form action="login.php" method="post">
        <input type="hidden" name="user_type" value="<?php echo $type; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>

    <div class="signup-btns">
        <a href="signup.php?type=restaurant">Restaurant Signup</a>
        <a href="signup.php?type=customer">Customer Signup</a> 
    </div>
</body>
</html>
