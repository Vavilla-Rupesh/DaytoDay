<?php
session_start();
// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Debugging: Print POST data
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     echo "<pre>dfhsjdfsjkdfhsjkdf" ;
//     print_r($_POST);
//     echo "</pre>";
// }

// Handle Branch Addition
if (isset($_POST['add_branch'])) {
    $department = trim($_POST['department']);
    $section = trim($_POST['section']);

    if (!empty($department) && !empty($section)) {
        $department = $conn->real_escape_string($department);
        $section = $conn->real_escape_string($section);

        // Check if the branch already exists
        $sql_check_branch = "SELECT * FROM branches WHERE department = '$department' AND section = '$section'";
        $result = $conn->query($sql_check_branch);

        if ($result->num_rows == 0) {
            $sql = "INSERT INTO branches (department, section) VALUES ('$department', '$section')";
            if ($conn->query($sql) === TRUE) {

		$_SESSION['success_message'] = "Branch added successfully!";
       		header("Location: Add_details.php");
        	exit;

            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Branch already exists!";
        }
    } else {
        echo "Department and Section cannot be empty!";
    }
}

// Handle Semester Addition
if (isset($_POST['add_semester'])) {
    $semester_name = trim($_POST['semester_name']);

    if (!empty($semester_name)) {
        $semester_name = $conn->real_escape_string($semester_name);

        // Check if the semester already exists
        $sql_check_semester = "SELECT * FROM semesters WHERE semester_name = '$semester_name'";
        $result = $conn->query($sql_check_semester);

        if ($result->num_rows == 0) {
            $sql = "INSERT INTO semesters (semester_name) VALUES ('$semester_name')";
            if ($conn->query($sql) === TRUE) {
		$_SESSION['success_message'] = "Semester added successfully!";
        	header("Location: Add_details.php");
        	exit;
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Semester already exists!";
        }
    } else {
        echo "Semester name cannot be empty!";
    }
}

// Handle Subject Addition
if (isset($_POST['add_subject'])) {
    if (!isset($_POST['branch_id']) || !isset($_POST['semester_id'])) {
        die("Error: Missing branch or semester selection.");
    }

    $subject_name = trim($_POST['subject_name']);
    $branch_id = trim($_POST['branch_id']);
    $semester_id = trim($_POST['semester_id']);
    $faculty_name = trim($_POST['faculty_name']);

    if (!empty($subject_name) && !empty($branch_id) && !empty($semester_id) && !empty($faculty_name)) {
        $subject_name = $conn->real_escape_string($subject_name);
        $branch_id = $conn->real_escape_string($branch_id);
        $semester_id = $conn->real_escape_string($semester_id);
        $faculty_name = $conn->real_escape_string($faculty_name);

        // Check if subject already exists
        $sql_check_subject = "SELECT * FROM subjects WHERE subject_name = '$subject_name' AND branch_id = '$branch_id' AND semester_id = '$semester_id'";
        $result = $conn->query($sql_check_subject);

        if ($result->num_rows == 0) {
            $sql = "INSERT INTO subjects (subject_name, branch_id, semester_id, faculty_name) 
                    VALUES ('$subject_name', '$branch_id', '$semester_id', '$faculty_name')";
            
            if ($conn->query($sql) === TRUE) {
		$_SESSION['success_message'] = "Subject added successfully!";
        	header("Location: Add_details.php");
        	exit;
            } else {
                echo "Error: " . $conn->error;
            }
        } else {

            // echo "Subject already exists for this branch and semester.";
        }
    } else {
        echo "All fields are required.";
    }
}

// Fetch existing data
$branches = $conn->query("SELECT * FROM branches");
$semesters = $conn->query("SELECT * FROM semesters");
$subjects = $conn->query("SELECT s.id, s.subject_name, b.department, b.section, sem.semester_name, s.faculty_name
                            FROM subjects s
                            JOIN branches b ON s.branch_id = b.id
                            JOIN semesters sem ON s.semester_id = sem.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Details</title>
    <style>
        * { font-family: Arial, sans-serif; }
        body {
            margin: 0;
            padding: 0;
            color: #333;
            display: flex; /* Add flexbox to body */
        min-height: 100vh;
        }
        .content {
        flex: 1; /* Content takes remaining space */
        padding: 20px;
    }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 { text-align: center; margin-bottom: 20px; }
        input, select, button {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        button { background: #007BFF; color: #fff; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background: #007BFF; color: #fff; }
        
    </style>
</head>
<body>
<?php include 'admin_menu.php'; ?>

    <div class="container">
        <h1>Add Details</h1>

        <form method="POST">
    <input type="text" name="department" placeholder="Department Name" required>
    <input type="text" name="section" placeholder="Section Name" required>
    <button type="submit" name="add_branch">Add Branch</button>
</form>

        

        <form method="POST">
            <input type="text" name="subject_name" placeholder="Add Subject" required>

            <select name="branch_id" required>
    <option value="">Select Department and Section</option>
    <?php
    $branches = $conn->query("SELECT * FROM branches"); // Fetch branches again
    while ($branch = $branches->fetch_assoc()):
        $branchName = $branch['department'] . '-' . $branch['section'];
    ?>
        <option value="<?php echo $branch['id']; ?>"><?php echo $branchName; ?></option>
    <?php endwhile; ?>
</select>

            <select name="semester_id" required>
                <option value="">Select Semester</option>
                <?php while ($semester = $semesters->fetch_assoc()): ?>
                    <option value="<?php echo $semester['id']; ?>"><?php echo $semester['semester_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <input type="text" name="faculty_name" placeholder="Faculty Name" required>
            <button type="submit" name="add_subject">Add Subject</button>
        </form>

        <table>
            <tr><th>Department</th><th>Section</th><th>Semester</th><th>Subject</th><th>Faculty</th></tr>
        <?php while ($subject = $subjects->fetch_assoc()): ?>
            <tr>
                <td><?= $subject['department']; ?></td>
                <td><?= $subject['section']; ?></td>
                <td><?= $subject['semester_name']; ?></td>
                <td><?= $subject['subject_name']; ?></td>
                <td><?= $subject['faculty_name']; ?></td>
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
        <a href="View_details.php">View Added Details</a>
        </div>
    </div>
	<div id="successModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 1000;">
    <p id="successMessage"></p>
    <button onclick="closeModal()">Close</button>
<script>
    function showModal(message) {
        document.getElementById('successMessage').textContent = message;
        document.getElementById('successModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('successModal').style.display = 'none';
    }

    <?php
    if (isset($_SESSION['success_message'])) {
        echo "showModal('" . $_SESSION['success_message'] . "');";
        unset($_SESSION['success_message']); // Clear the message
    }
    ?>
</script>
</div>
</body>
</html>
