<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND username = 'admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (hash('sha256', $password) === $admin['password']) {
            session_start();
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin_dashboard.php');
            exit();
        } else {
            echo "<script>alert('Incorrect Password');</script>";
        }
    } else {
        echo "<script>alert('Admin not found');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
                        display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 400px;
        }
        .container h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
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
        <h1>Admin Login</h1>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group"  style="display: flex;justify-content:center;">
                <button type="submit" style="width: fit-content;">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
