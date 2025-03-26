<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            if ($row['verified'] == 1) { // Check if verified
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['department'] = $row['department']; // Store department
                $_SESSION['section'] = $row['section']; // Store section
                $_SESSION['semester'] = $row['semester']; // Store semester
                $_SESSION['branch_name'] = $row['department'] . '-' . $row['section']; // Store reconstructed branch_name
                header("Location: feedback.php"); // Redirect to the dashboard or home page
            } else {
                echo "<script>alert('Your account has not been verified by the admin.');</script>";
            }
        } else {
            echo "<script>alert('Invalid Password!');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0);
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>