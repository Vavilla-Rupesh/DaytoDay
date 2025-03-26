<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day to Day Faculty Feedback</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .top-right a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2em;
            padding: 10px 15px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .top-right a:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .container {
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
        a{
            margin-right: 20px;
        }
        .container h1 {
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        .container p {
            margin-bottom: 30px;
            font-size: 1.2em;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background: #007BFF;
            color: #fff;
            text-decoration: none;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5a6268;
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
        <img src="Images/logo.jpeg" style="width: 500px;height: 180px;" alt="">
    </div>

    <div class="container">
        <h1>Day to Day Classroom Experience Tracker</h1>
        <p>Please log in or register to access your account.</p>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn btn-secondary">Register</a>
    </div>
    <div class="top-right">
    <a href="about.php">About Us</a>
    <a href="admin/admin_index.php" style="margin-left: 10px;">Admin</a>
</div>
</body>
</html>
