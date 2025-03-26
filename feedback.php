
<?php
session_start();
// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'] ?? '';
    $user_id = $_SESSION['user_id'] ?? '';
    $user_email = '';

    if (!empty($user_id)) {
        $email_query = "SELECT email FROM users WHERE id = ?";
        $stmt = $conn->prepare($email_query);
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $user_email = $row['email'];
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing email query: " . $conn->error . "');</script>";
        }
    }

    // Loop through the 7 feedback rows
    for ($i = 1; $i <= 7; $i++) {
        $subject_id = $_POST['subject_id' . $i] ?? '';
        $faculty_name = $_POST['faculty_name' . $i] ?? '';
        $topic_explained = $_POST['topic_explained' . $i] ?? '';
        $rating = $_POST['rating' . $i] ?? '';
        $suggestion = $_POST['suggestion' . $i] ?? '';
        $period = $_POST['period' . $i] ?? '';

        if (!empty($subject_id) && !empty($faculty_name) && !empty($topic_explained) && !empty($rating) && !empty($period) && !empty($user_id)) {
            

            $sql = "INSERT INTO topics (date, subject_id, faculty_name, topic_explained, rating, suggestion, period, user_id, user_email) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {

                

                $stmt->bind_param("ssssssiss", $date, $subject_id, $faculty_name, $topic_explained, $rating, $suggestion, $period, $user_id, $user_email);

                if ($stmt->execute()) {
                    // Success for this row
                } else {
                    echo "<script>alert('Error in row " . $i . ": " . $stmt->error . "');</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('Error preparing insert query for row " . $i . ": " . $conn->error . "');</script>";
            }

        } else {
            echo "<script>alert('All fields in row " . $i . " are required!');</script>";
        }
    } // End of the loop

    echo "<script>alert('Feedback submitted successfully!');</script>"; // Overall success message
}

// Fetch branches
$branches = $conn->query("SELECT id, department, section FROM branches");

// Fetch semesters
$semesters = $conn->query("SELECT id, semester_name FROM semesters");



// Fetch subjects
if (isset($_SESSION['branch_name']) && isset($_SESSION['semester'])) {
    $user_branch = $_SESSION['branch_name'];
    $user_semester = $_SESSION['semester'];
    list($department, $section) = explode('-', $user_branch);
    $subjects = $conn->query("SELECT s.id AS subject_id, s.subject_name, s.faculty_name, s.branch_id, s.semester_id, b.department, b.section, sem.semester_name FROM subjects s JOIN branches b ON s.branch_id = b.id JOIN semesters sem ON s.semester_id = sem.id WHERE b.department = '$department' AND b.section = '$section' AND sem.semester_name = '$user_semester'");
} else {
    // If branch_name or semester is not set, fetch all subjects (or handle as needed)
    $subjects = $conn->query("SELECT s.id AS subject_id, s.subject_name, s.faculty_name, s.branch_id, s.semester_id, b.department, b.section, sem.semester_name FROM subjects s JOIN branches b ON s.branch_id = b.id JOIN semesters sem ON s.semester_id = sem.id");
}



$subjectData = [];
while ($row = $subjects->fetch_assoc()) {
    $subjectData[] = $row;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
//$branch_name = isset($_SESSION['branch_name']) ? $_SESSION['branch_name'] : 'N/A';
//list($department, $section) = explode('-', $branch_name);
//$semester = isset($_SESSION['semester']) ? $_SESSION['semester'] : 'N/A';

if (isset($_SESSION['branch_name'])) {
    $branch_name = $_SESSION['branch_name'];
    $branch_parts = explode('-', $branch_name);
    $department = isset($branch_parts[0]) ? $branch_parts[0] : 'N/A';
    $section = isset($branch_parts[1]) ? $branch_parts[1] : 'N/A';
} else {
    $department = 'N/A';
    $section = 'N/A';
}
$semester = isset($_SESSION['semester']) ? $_SESSION['semester'] : 'N/A';

// Calculate today's and yesterday's date
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day')); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
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
            background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 10px;
    max-width: 950px; /* Set your desired max-width */
    width: 90%; /* Use percentage for responsiveness */
    margin: 20px auto; /* Center the container */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input, select, textarea, button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Add some top margin to the table */
        }

        th, td {
            border: 1px solid #ddd; /* Add borders to table cells */
            padding: 8px; /* Add padding to table cells */
            text-align: left; /* Align text to the left */
        }

        th {
            background-color: #f2f2f2; /* Add a light background color to table headers */
        }
        .period-rating{
            display: flex;
        }
        .period-rating select{
            margin-right: 10px;
        }
        .username-display {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.2em;
        }
.feedback-row {
    display: flex;
    align-items: center;
    justify-content: center; /* Center horizontally */
    margin-bottom: 10px;
}

.feedback-row > * { /* Target all direct children for consistent spacing */
    margin-right: 30px; /* Space around each element */
}

.feedback-row label {
    white-space: nowrap; /* Prevent labels from wrapping */
}

.feedback-row select {
    flex: 0 0 auto; /* Prevent select from stretching */
}

/* Optional: If you need specific width for the date select */
/* .feedback-row select[name="date"] {
    width: 150px;
} */

    </style>
    <script>
        const subjectsData = <?php echo json_encode($subjectData); ?>;

function updateSubjects(rowNumber) {
    let subjectDropdown = document.getElementById('subject_id' + rowNumber);
    subjectDropdown.innerHTML = '<option value="">Select Subject</option>';

    subjectsData.forEach(subject => {
        let option = document.createElement('option');
        option.value = subject.subject_id;
        option.innerHTML = subject.subject_name;
        subjectDropdown.appendChild(option);
    });
}

function updateFacultyName(rowNumber) {
    const subjectId = document.getElementById('subject_id' + rowNumber).value;
    const selectedSubject = subjectsData.find(subject => subject.subject_id == subjectId);
    document.getElementById('faculty_name' + rowNumber).value = selectedSubject ? selectedSubject.faculty_name : '';
}

window.addEventListener('DOMContentLoaded', function() {
    for (let i = 1; i <= 7; i++) {
        updateSubjects(i);
    }
});
</script>
</head>
<body>
<div class="container">
        <div class="username-display">
            Welcome, <?php echo htmlspecialchars($username); ?>!
        </div>
        <h1>Feedback</h1>
        <form method="POST">
            <div class="feedback-row">
                <label>Date:</label>
                <select name="date" required>
                    <option value="<?php echo $today; ?>"><?php echo $today; ?></option>
                    <option value="<?php echo $yesterday; ?>"><?php echo $yesterday; ?></option>
                </select>
		<label>Branch:<?php echo htmlspecialchars($department); ?></label>
		<label>Section: <?php echo htmlspecialchars($section); ?></label>
		<label>Semester: <?php echo htmlspecialchars($semester); ?></label>


            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Subject</th>
                        <th>Faculty Name</th>
                        <th>Topics Explained</th>
                        <th>Rating</th>
                        <th>Suggestions/Queries</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <tr>
                            <td>
                                <input type="hidden" name="period<?php echo $i; ?>" value="<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <select name="subject_id<?php echo $i; ?>" id="subject_id<?php echo $i; ?>" onchange="updateFacultyName(<?php echo $i; ?>)" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </td>
                            <td><input type="text" name="faculty_name<?php echo $i; ?>" id="faculty_name<?php echo $i; ?>" readonly></td>
                            <td><textarea name="topic_explained<?php echo $i; ?>" id="topic_explained<?php echo $i; ?>" required></textarea></td>
                            <td>
                                <select name="rating<?php echo $i; ?>" id="rating<?php echo $i; ?>" required>
                                    <option value="">Rating</option>
                                    <option value="Excellent">Excellent</option>
                                    <option value="Very Good">Very Good</option>
                                    <option value="Good">Good</option>
                                    <option value="Satisfactory">Satisfactory</option>
                                    <option value="Poor">Poor</option>
				    <option value="Class Not Held">Class Not Held</option>
                                </select>
                            </td>
                            <td><textarea name="suggestion<?php echo $i; ?>" id="suggestion<?php echo $i; ?>" ></textarea></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <div class="feedback-row">
                <button type="submit">Submit</button>
            </div>
        </form>
        <a href="index.php" style="display: block; text-align: center; margin-top: 20px; text-decoration: none; color: blue;">Dashboard</a>
    </div>
</body>
</html>