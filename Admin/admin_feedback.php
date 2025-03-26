<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_auth');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Initialize filters
$date_filter = '';
$faculty_filter = '';
$selected_ratings_order = [];


// Handle form submission for filtering
$query = "
    SELECT u.rollno AS roll_no, SUBSTRING_INDEX(u.branch_name, '-', 1) AS department, u.section, u.semester, u.username, t.id, t.date, s.subject_name, t.faculty_name,
        t.topic_explained, t.rating, t.suggestion, t.period, t.submitted_at
    FROM topics t
    JOIN subjects s ON t.subject_id = s.id
    JOIN users u ON t.user_id = u.id
    WHERE 1=1
";

$filters = [];
$types = '';
$params = [];

if (!empty($_POST['filter_date_from']) && !empty($_POST['filter_date_to'])) {
    $query .= " AND t.date BETWEEN ? AND ?";
    $filters[] = $_POST['filter_date_from'];
    $filters[] = $_POST['filter_date_to'];
    $types .= 'ss';
}
if (!empty($_POST['filter_faculty'])) {
    $query .= " AND t.faculty_name = ?";
    $filters[] = $_POST['filter_faculty'];
    $types .= 's';
}

// Add Feedback Rating Filter

$selected_ratings =[];
if (isset($_POST['filter_rating'])) {
    $selected_ratings = (array)$_POST['filter_rating'];
    // Store the selected ratings in the order they appear in $_POST
    $selected_ratings_order = $selected_ratings;
	$selected_ratings_order = array_reverse($selected_ratings_order);
}

if (!empty($selected_ratings)) {
    $query .= " AND t.rating IN ('" . implode("','", $selected_ratings) . "')";
}

//$query .= " ORDER BY t.date DESC";

if (!empty($selected_ratings)) {
    // Sort by the order of checked ratings first, then by date
    $query .= " ORDER BY FIELD(t.rating, '" . implode("','", $selected_ratings) . "'), t.date DESC";
} else {
    // Default sorting by date
    $query .= " ORDER BY t.date DESC";
}

// Execute the query with filters
$stmt = $conn->prepare($query);
if (!empty($filters)) {
    $stmt->bind_param($types, ...$filters);
}
$stmt->execute();
$feedback = $stmt->get_result();

// Fetch all unique faculty names for the dropdown
$faculty_names = $conn->query("SELECT DISTINCT faculty_name FROM topics");

// Export to Excel Function
function exportFeedbackToExcel($conn, $query, $filters, $types, $selected_ratings_order) {
    $stmt = $conn->prepare($query);
    if (!empty($filters)) {
        $stmt->bind_param($types, ...$filters);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="admin_feedback_data.xls"');

        echo "<table>";
        echo "<tr><th>Period</th><th>Roll No</th><th>Username</th><th>Department</th><th>Section</th><th>Semester</th><th>Subject</th><th>Faculty</th><th>Topic Explained</th><th>Rating</th><th>Suggestion</th><th>Date</th><th>Submitted At</th></tr>"; 

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['period'] . "</td>";
        echo "<td>" . $row['roll_no'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['department'] . "</td>";
        echo "<td>" . $row['section'] . "</td>";
        echo "<td>" . $row['semester'] . "</td>";
         
        echo "<td>" . $row['subject_name'] . "</td>";
        echo "<td>" . $row['faculty_name'] . "</td>";
        echo "<td>" . $row['topic_explained'] . "</td>";
        echo "<td>" . $row['rating'] . "</td>";
        echo "<td>" . $row['suggestion'] . "</td>";
        echo "<td>" . date('d-m-Y', strtotime($row['date'])) . "</td>";
        echo "<td>" . date('H:i:s', strtotime($row['submitted_at'])) . "</td>";
        echo "</tr>";
    }
        echo "</table>";
    } else {
        echo "No feedback data found.";
    }
    exit; // Stop further execution
}

// Handle export request
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    // ... (Get other filter parameters from $_GET)

    $selected_ratings_order = []; // Initialize here!
    if (isset($_GET['filter_rating'])) {
        $selected_ratings_order = explode(',', $_GET['filter_rating']);
        $selected_ratings_order = array_reverse($selected_ratings_order);
    }

    //Build query
    $query = "
    SELECT u.rollno AS roll_no, SUBSTRING_INDEX(u.branch_name, '-', 1) AS department, u.section, u.semester, u.username, t.id, t.date, s.subject_name, t.faculty_name,
        t.topic_explained, t.rating, t.suggestion, t.period, t.submitted_at
    FROM topics t
    JOIN subjects s ON t.subject_id = s.id
    JOIN users u ON t.user_id = u.id
    WHERE 1=1
";
    $filters = [];
    $types = '';

    if (!empty($_GET['filter_date_from']) && !empty($_GET['filter_date_to'])) {
        $query .= " AND t.date BETWEEN ? AND ?";
        $filters[] = $_GET['filter_date_from'];
        $filters[] = $_GET['filter_date_to'];
        $types .= 'ss';
    }
    if (!empty($_GET['filter_faculty'])) {
        $query .= " AND t.faculty_name = ?";
        $filters[] = $_GET['filter_faculty'];
        $types .= 's';
    }

    if (!empty($selected_ratings_order)) {  // Use $selected_ratings_order here
        $placeholders = implode(',', array_fill(0, count($selected_ratings_order), '?'));
        $query .= " AND t.rating IN ($placeholders)";

        $filters = array_merge($filters, $selected_ratings_order);  // Add selected ratings to filters
        $types .= str_repeat('s', count($selected_ratings_order)); // Type string for binding
    }

    if (!empty($selected_ratings_order)) {
        $query .= " ORDER BY FIELD(t.rating, '" . implode("','", $selected_ratings_order) . "'), t.date DESC";
    } else {
        $query .= " ORDER BY t.date DESC";
    }

    exportFeedbackToExcel($conn, $query, $filters, $types, $selected_ratings_order); // Pass $selected_ratings_order
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Feedback</title>
    <style>
        /* ... (Your CSS styles) ... */
	 * { font-family: Arial, sans-serif; }
        body {
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .container {
            max-width: 1450px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 { text-align: center; margin-bottom: 20px; }
        form { text-align: center; margin-bottom: 20px; }
        input[type="date"], select, button {
            padding: 10px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
	
        button { background: #007BFF; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background: #007BFF; color: white; }
        .no-data { text-align: center; margin: 20px; }
        th:nth-child(2), td:nth-child(2) { width: 200px; }
        th:nth-child(3), td:nth-child(3) { width: 150px; }
	
	.rating-filter {
  		align-items: center;
		text-align : center;
		flex-wrap: wrap;
  		gap: 10px;
	}
    .date-column {
        width: 130px; /* Adjust the width as needed */
        min-width: 100px; /* optional, to prevent shrinking below a minimum */
    }

	.rating-filter label {
		text-align : center;

  		align-items: center;
  		margin-right: 10px;
	}

	.rating-filter input[type="checkbox"] {
  		margin-right: 0px;
		margin-left: 10px
	}


    </style>
    <script>
    function exportToExcel() {
        var fromDate = document.getElementById('filter_date_from').value;
        var toDate = document.getElementById('filter_date_to').value;
        var faculty = document.getElementById('filter_faculty').value;
        var url = '?export=excel';
        if (fromDate) {
            url += '&filter_date_from=' + fromDate;
        }
        if (toDate) {
            url += '&filter_date_to=' + toDate;
        }
        if (faculty) {
            url += '&filter_faculty=' + faculty;
        }
        var selectedRatings = [];
        var ratingCheckboxes = document.querySelectorAll('input[name="filter_rating[]"]:checked'); // Correct name
        for (var i = 0; i < ratingCheckboxes.length; i++) {
            selectedRatings.push(ratingCheckboxes[i].value);
        }

        if (selectedRatings.length > 0) {
            url += '&filter_rating=' + selectedRatings.join(','); // Send as comma-separated values
        }

        window.location.href = url;
    }
    </script>
</head>
<body>
<?php include 'admin_menu.php'; ?>


    <div class="container">
        <h1>User Feedback</h1>

        <form method="POST">
    		<label for="filter_date_from"><b>From Date:</b></label>
		<input type="date" name="filter_date_from" id="filter_date_from" value="<?php echo $_POST['filter_date_from'] ?? ''; ?>">

    		<label for="filter_date_to"><b>To Date:</b></label>
    		<input type="date" name="filter_date_to" id="filter_date_to" value="<?php echo $_POST['filter_date_to'] ?? ''; ?>">

    		<label for="filter_faculty"><b>Filter by Faculty:</b></label>
    		<select name="filter_faculty" id="filter_faculty">
			<option value="">Select Faculty</option>
        		<?php while ($row = $faculty_names->fetch_assoc()): ?>
            			<option value="<?php echo $row['faculty_name']; ?>" <?php echo ($_POST['filter_faculty'] ?? '') === $row['faculty_name'] ? 'selected' : ''; ?>>
                			<?php echo $row['faculty_name']; ?>
            			</option>
        		<?php endwhile; ?>
    		</select>
    <br> <br>   
    <div class="rating-filter"> <label><b>Filter by Rating:</b></label>   
	<label><input type="checkbox" name="filter_rating[]" value="Excellent" <?php if (in_array("Excellent", $selected_ratings)) echo "checked"; ?>> Excellent</label>
        <label><input type="checkbox" name="filter_rating[]" value="Very Good" <?php if (in_array("Very Good", $selected_ratings)) echo "checked"; ?>> Very Good</label>
        <label><input type="checkbox" name="filter_rating[]" value="Good" <?php if (in_array("Good", $selected_ratings)) echo "checked"; ?>> Good</label>
        <label><input type="checkbox" name="filter_rating[]" value="Satisfactory" <?php if (in_array("Satisfactory", $selected_ratings)) echo "checked"; ?>> Satisfactory</label>
        <label><input type="checkbox" name="filter_rating[]" value="Poor" <?php if (in_array("Poor", $selected_ratings)) echo "checked"; ?>> Poor</label>
        <label><input type="checkbox" name="filter_rating[]" value="Class Not Held" <?php if (in_array("Class Not Held", $selected_ratings)) echo "checked"; ?>> Class Not Held</label>
    </div>

    <button type="submit"><b>Filter</b></button>
    <button type="button" onclick="window.location.href='admin_feedback.php'"><b>Reset</b></button>
</form>

        <?php if ($feedback->num_rows > 0): ?>
            <table>
    <thead>
        <tr>
            <th>Period</th>
            <th>Roll No</th>
            <th>Student Name</th>
            <th>Department</th>
            <th>Section</th>
            <th>Semester</th>
            
            <th>Name of the Subject</th>
            <th>Name of the Faculty</th>
            <th>Topic Explained</th>
            <th>Feedback Rating</th>
            <th>Suggestions</th>
            <th class="date-column">Date</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $feedback->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['period']); ?></td>
                <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['department']); ?></td>
                <td><?php echo htmlspecialchars($row['section']); ?></td>
                <td><?php echo htmlspecialchars($row['semester']); ?></td>
                <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                <td><?php echo htmlspecialchars($row['faculty_name']); ?></td>
                <td><?php echo htmlspecialchars($row['topic_explained']); ?></td>
                <td><?php echo htmlspecialchars($row['rating']); ?></td>
                <td><?php echo htmlspecialchars($row['suggestion']); ?></td>
                <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['date']))); ?></td>
                <td class="date-column"><?php echo htmlspecialchars(date('H:i:s', strtotime($row['submitted_at']))); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
        <?php else: ?>
            <p class="no-data">No feedback data available for the selected filters.</p>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 20px;">
            <button type="button" onclick="exportToExcel()">Export to Excel</button>
        </div>

        <a href="admin_dashboard.php" style="display: block; text-align: center; margin-top: 20px; text-decoration: none; color: blue;">Back to Dashboard</a>
    </div>
</body>
</html>