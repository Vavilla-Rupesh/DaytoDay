<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            font-family: Arial, sans-serif;
        }
        body {
            
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        

        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        .menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .menu a {
            text-decoration: none;
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .menu a:hover {
            background: #0056b3;
        }
        .unkown{
            z-index: -999;
            background-color: white;
            position: fixed;
            color: black;
        top: -20px;
        left: 0px;
        }
    </style>
</head>
<body>
<div class="unkown">
        <img src="logo.jpeg" style="width: 500px;height: 180px;" alt="">
    </div>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome to the Admin Dashboard for the Day-to-Day Faculty Tracker. Admin module provides an overview of key metrics and real-time data to help you manage faculty activities efficiently.</p>
        <div class="menu">
            <a href="admin_login.php">Admin Login</a>
        </div>
    </div>
</body>
</html>
