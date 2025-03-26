<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}
if (isset($_GET['verify'])) {
  $user_id = $_GET['verify'];
  $sql = "UPDATE users SET verified = 1 WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  if ($stmt->execute()) {
      echo "<script>alert('User verified successfully!');</script>";
  } else {
      echo "<script>alert('Error verifying user: " . $stmt->error . "');</script>";
  }
  $stmt->close();
}

// Fetch all users
$sql = "SELECT id, username, email, created_at, verified FROM users WHERE username != 'admin'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <style>
      /* ... (Add your table styling from the original admin_dashboard.php here) ... */
      body {
        font-family: Arial, sans-serif;
        margin: 0;
            display: flex; /* Add flexbox to body */
            min-height: 100vh;
      }
      .content {
            flex: 1; /* Content takes remaining space */
            padding: 20px;
        }
      table {
        width: 80%;
        margin: 20px auto; /* Center the table */
        border-collapse: collapse;
      }
      table, th, td {
        border: 1px solid #ddd;
      }
      th, td {
        padding: 10px;
        text-align: left;
      }
      th {
        background-color: #007BFF;
        color: white;
      }
      .verify-button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        .verify-button:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
<?php include 'admin_menu.php'; ?>

<div class="content">
  <table>
    <tr>
      <th>Username</th>
      <th>Email</th>
      <th>Created At</th>
      <th>Verified</th>
            <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td><?php echo $row['verified'] ? 'Yes' : 'No'; ?></td>
        <td>
                    <?php if (!$row['verified']): ?>
                        <a href="view_users.php?verify=<?php echo $row['id']; ?>" class="verify-button">Verify</a>
                    <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>