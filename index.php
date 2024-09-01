<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
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
            margin-bottom: 1em;
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
    <h1>Welcome To Our Platform</h1>
    <a href="login.php?type=restaurant">Restaurant Login</a>
    <a href="login.php?type=customer">Customer Login</a>
    <a href="login.php?type=admin">Admin Login</a>
</body>
</html>
