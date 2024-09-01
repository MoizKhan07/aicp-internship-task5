<?php
session_start();

if ($_SESSION['user_type'] != 'admin') {
    header("Location: login.php?type=admin");
    exit();
}

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
    $userId = $_POST['user_id'];
    $sql = "UPDATE users SET is_approved = 1 WHERE id = $userId";
    if ($conn->query($sql) === TRUE) {
        echo "User approved successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$sql = "SELECT * FROM users WHERE is_approved = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body{
            background-image: url(admin-bg.jpg);
            background-size: cover;
        }
        a{
            background-color: #4cae4c;
            color: white;
            padding: .5em 1em;
            width: 100px;
            text-align: center;
            border-radius: 2px;
            margin-bottom: 1em;
            transition: ease .7s;
        }

        a:hover{
            background-color: white;
            border: 1px solid #4cae4c;
            color: #4cae4c;
        }
        .nav{
            position: absolute;
            top: 0;
            display: flex; 
            padding: 1em; 
            justify-content: space-between; 
            align-items: center; 
            background-color: #333; 
            width: 100%; 
            color:aliceblue;
        }
    </style>
</head>
<body>

    <div class="nav">
        <h3>Admin</h3>
        <a href="index.php">Logout</a>
    </div>

    <h2 style="color: whitesmoke; text-shadow: 10px 10px 50px black;">Admin Panel - Approve Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['user_type']; ?></td>
                <td>
                    <form action="admin_panel.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="approve">Approve</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
