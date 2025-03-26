<?php
session_start();

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Database Connection
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Fetch Departments & Sections
$departments = $conn->query("SELECT DISTINCT department FROM branches");
$sections = $conn->query("SELECT DISTINCT section FROM branches");

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $rollno = $_POST['rollno'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $department = $_POST['department'];
    $section = $_POST['section'];
    $semester = $_POST['semester'];
    $branch_name = $department . '-' . $section;

    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['register_data'] = compact('username', 'rollno', 'email', 'password', 'department', 'section', 'branch_name', 'semester');

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Send OTP via Email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($_ENV['SMTP_USER'], 'Day to Day Feedback');
        $mail->addAddress($email);

        $mail->Subject = "Your OTP for Registration";
        $mail->Body = "Your OTP is: $otp";

        $mail->send();
        header("Location: verify_otp.php");
        exit();
    } catch (Exception $e) {
        echo "<script>alert('Email could not be sent: " . $mail->ErrorInfo . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background: #0056b3;
        }

        .unkown {
            z-index: -999;
            background-color: white;
            position: fixed;
            color: black;
            top: -10px;
            left: 0px;
        }

        .unkown img {
            width: 500px;
            height: 180px;
        }
    </style>
</head>

<body>
    <div class="unkown">
        <img src="Images/logo.jpeg" style="width: 500px;height: 180px;" alt="">
    </div>

    <div class="container">
        <h1>Register</h1>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Roll No</label>
                <input type="text" name="rollno" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Department</label>
                <select name="department" required>
                    <?php
                    if ($departments->num_rows > 0) {
                        while ($row = $departments->fetch_assoc()) {
                            echo '<option value="' . $row['department'] . '">' . $row['department'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No Departments Found</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Section</label>
                <select name="section" required>
                    <?php
                    if ($sections->num_rows > 0) {
                        while ($row = $sections->fetch_assoc()) {
                            echo '<option value="' . $row['section'] . '">' . $row['section'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No Sections Found</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Semester</label>
                <select name="semester" required>
                    <option value="1-1">1-1</option>
                    <option value="1-2">1-2</option>
                    <option value="2-1">2-1</option>
                    <option value="2-2">2-2</option>
                    <option value="3-1">3-1</option>
                    <option value="3-2">3-2</option>
                    <option value="4-1">4-1</option>
                    <option value="4-2">4-2</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>

</html>