<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Verify OTP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp'];
    if ($entered_otp == $_SESSION['otp']) {
        extract($_SESSION['register_data']);
        $sql = "INSERT INTO users (username, rollno, email, password, department, section, branch_name, semester) 
                VALUES ('$username', '$rollno', '$email', '$password', '$department', '$section', '$branch_name', '$semester')";
        if ($conn->query($sql) === TRUE) {
            unset($_SESSION['otp'], $_SESSION['register_data']);
            echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid OTP!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            width: 350px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-size: 16px;
            color: #555;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <form method="POST">
            <label>Enter OTP:</label><br>
            <input type="text" name="otp" required><br>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
