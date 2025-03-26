<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Fetch subjects with associated branch, semester, and faculty details
$sql = "SELECT s.subject_name, b.branch_name, sem.semester_name, s.faculty_name
        FROM subjects s
        JOIN branches b ON s.branch_id = b.id
        JOIN semesters sem ON s.semester_id = sem.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Subjects</title>
    <style>
        * {
            font-family: Arial, sans-serif;
        }
        body {
                        margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007BFF;
            color: #fff;
        }
            </style>
</head>
<body>

    <div class="container">
        <h1>Subjects and Associated Details</h1>

        <!-- Display Subjects -->
        <table>
            <tr>
                <th>Subject Name</th>
                <th>Branch Name</th>
                <th>Semester Name</th>
                <th>Faculty Name</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['branch_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['semester_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['faculty_name']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <div style="display: flex;justify-content: center;">
            <style>
                a{
                    margin-top: 2%;
                    text-decoration: none;
                }
            </style>
        <a href="admin_dashboard.php">View Dashboard</a>
    
        </div>
    </div>

</body>
</html>
