<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body{
            background-image: url(background.jpg);
            margin: 0;
            padding: 0;
            font-size: 23px;
        }
        .nav{
            display: flex; 
            padding: 1em;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color:aliceblue;
        }

        .container{
            display: flex;
            flex-direction: column;
            gap: 1em;
            width: 100%;
            padding: 2em;
            justify-content: center;
            align-items: center;
        }

        a{
            text-decoration: none;
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
    <div class="nav">
        <h3>Restaurant</h3>
        <a href="index.php" style="width: 60px;">Logout</a>
    </div>

    <div class="container">
        <a href="view_orders.php">Orders</a>
        <a href="add_dishes.php">Add dishes</a>
    </div>
</body>
</html>