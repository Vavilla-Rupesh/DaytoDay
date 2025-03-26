<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 30px;
            background-color: #f0f0f0;
            padding: 20px;
            transition: width 0.3s ease-in-out;
        }

        .sidebar.expanded {
            width: 200px;
        }

        .menu-icon {
            cursor: pointer;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .menu-items {
            display: none;
        }

        .menu-items a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .menu-items a:hover {
            background-color: #ddd;
        }

        .content {
            flex: 1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        h1 {
            margin-top: 0;
            color: grey;
        }
    </style>
</head>
<body>

<div class="sidebar">
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <div class="menu-items" id="menuItems">
            <a href="view_users.php">View Users</a>
            <a href="Admin_feedback.php">View Feedback</a>
            <a href="Add_details.php">Add Details</a>
            <a href="modify_details.php">Modify Details</a>
            <a href="admin_logout.php">Logout</a> </div>
    </div>

    <div class="content">
        <h1>Welcome to Admin Dashboard</h1>
    </div>

    <script>
        function toggleMenu() {
            var sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('expanded');

            var menuItems = document.getElementById("menuItems");
            if (sidebar.classList.contains('expanded')) {
                menuItems.style.display = 'block';
            } else {
                menuItems.style.display = 'none';
            }
        }
        
    </script>

</body>
</html>