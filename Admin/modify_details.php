<?php
// Database connection and error handling
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Handle Branch Deletion
if (isset($_POST['delete_branch'])) {
    $branch_id = $conn->real_escape_string($_POST['branch_id']);
    $sql = "DELETE FROM branches WHERE id = '$branch_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Branch deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting branch: " . $conn->error . "');</script>";
    }
}

// Handle Subject Deletion
if (isset($_POST['delete_subject'])) {
    $subject_id = $conn->real_escape_string($_POST['subject_id']);
    $sql = "DELETE FROM subjects WHERE id = '$subject_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Subject deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting subject: " . $conn->error . "');</script>";
    }
}

// Handle Faculty Modification
if (isset($_POST['modify_faculty'])) {
    $branch_id = $conn->real_escape_string($_POST['branch_id_modify']);
    $subject_id = $conn->real_escape_string($_POST['subject_id_modify']);
    $faculty_name = $conn->real_escape_string($_POST['faculty_name']);
    $sql = "UPDATE subjects SET faculty_name = '$faculty_name' WHERE id = '$subject_id' AND branch_id = '$branch_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Faculty modified successfully!');</script>";
    } else {
        echo "<script>alert('Error modifying faculty: " . $conn->error . "');</script>";
    }
}

// Fetch existing data
$branches = $conn->query("SELECT * FROM branches");
$semesters = $conn->query("SELECT * FROM semesters");
$subjects = $conn->query("SELECT s.id, s.subject_name, b.department, b.section, sem.semester_name, s.faculty_name, s.branch_id FROM subjects s JOIN branches b ON s.branch_id = b.id JOIN semesters sem ON s.semester_id = sem.id");

// Prepare subjectsByBranch for JavaScript
$subjectsByBranch = [];
$subjects->data_seek(0);
while ($subject = $subjects->fetch_assoc()) {
    $subjectsByBranch[$subject['branch_id']][] = $subject;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Details</title>
    <style> body { font-family: Arial, sans-serif; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 30px; background-color: #f0f0f0; padding: 20px; transition: width 0.3s ease-in-out; }
        .sidebar.expanded { width: 200px; }
        .menu-icon { cursor: pointer; font-size: 24px; margin-bottom: 10px; }
        .menu-items { display: none; }
        .menu-items a { display: block; padding: 10px; text-decoration: none; color: #333; }
        .menu-items a:hover { background-color: #ddd; }
        .content { flex: 1; padding: 20px; }
        .container { max-width: 1200px; margin: 20px auto; background: rgba(255, 255, 255, 0.9); padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        h1 { text-align: center; margin-bottom: 20px; }
        input, select, button { padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 5px; width: 100%; box-sizing: border-box; }
        button { background: #007BFF; color: #fff; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background: #007BFF; color: #fff; }
</style>
</head>
<body>
<?php include 'admin_menu.php'; ?>
    

    <div class="content">
        <div class="container">
            <h1>Modify Details</h1>

            <form method="POST">
                <select name="branch_id" required>
                    <option value="">Select Branch to Delete</option>
                    <?php
                    $branches->data_seek(0);
                    while ($branch = $branches->fetch_assoc()):
                    ?>
                        <option value="<?php echo $branch['id']; ?>"><?php echo $branch['department'] . '-' . $branch['section']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" name="delete_branch">Delete Branch</button>
            </form>

            <form method="POST">
                <select name="branch_id" id="branch_select_delete" onchange="updateSubjectsToDelete()">
                    <option value="">Select Branch</option>
                    <?php
                    $branches->data_seek(0);
                    while ($branch = $branches->fetch_assoc()):
                    ?>
                        <option value="<?php echo $branch['id']; ?>"><?php echo $branch['department'] . '-' . $branch['section']; ?></option>
                    <?php endwhile; ?>
                </select>

                <select name="subject_id" id="subject_select_delete">
                    <option value="">Select Subject to Delete</option>
                </select>

                <button type="submit" name="delete_subject">Delete Subject</button>
            </form>

            <form method="POST">
                <select name="branch_id_modify" id="branch_select_modify" onchange="updateSubjectsToModify()">
                    <option value="">Select Branch</option>
                    <?php
                    $branches->data_seek(0);
                    while ($branch = $branches->fetch_assoc()):
                    ?>
                        <option value="<?php echo $branch['id']; ?>"><?php echo $branch['department'] . '-' . $branch['section']; ?></option>
                    <?php endwhile; ?>
                </select>

                <select name="subject_id_modify" id="subject_select_modify">
                    <option value="">Select Subject to Modify Faculty</option>
                </select>

                <input type="text" name="faculty_name" placeholder="New Faculty Name" required>
                <button type="submit" name="modify_faculty">Modify Faculty</button>
            </form>

            <table>
                <tr><th>Department</th><th>Section</th><th>Semester</th><th>Subject</th><th>Faculty</th></tr>
                <?php
                $subjects->data_seek(0);
                while ($subject = $subjects->fetch_assoc()):
                ?>
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
                    a{margin-top: 2%;
                        text-decoration: none;
                    }
                </style>
                <a href="Add_details.php">Go Back</a>
            </div>
        </div>
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

    function updateSubjectsToDelete() {
        var branchId = parseInt(document.getElementById('branch_select_delete').value);
        var subjectSelect = document.getElementById('subject_select_delete');
        subjectSelect.innerHTML = '<option value="">Select Subject to Delete</option>';

        if (branchId && subjectsByBranch[branchId]) {
            subjectsByBranch[branchId].forEach(function(subject) {
                var option = document.createElement('option');
                option.value = subject.id;
                option.text = subject.subject_name;
                subjectSelect.appendChild(option);
            });
        }
    }

    function updateSubjectsToModify() {
        var branchId = parseInt(document.getElementById('branch_select_modify').value);
        var subjectSelect = document.getElementById('subject_select_modify');
        subjectSelect.innerHTML = '<option value="">Select Subject to Modify Faculty</option>';

        if (branchId && subjectsByBranch[branchId]) {
            subjectsByBranch[branchId].forEach(function(subject) {
                var option = document.createElement('option');
                option.value = subject.id;
		option.text = subject.subject_name;
                subjectSelect.appendChild(option);
            });
        }
    }

    <?php
    echo 'var subjectsByBranch = ' . json_encode($subjectsByBranch) . ';';
    ?>
</script>

</body>
</html>