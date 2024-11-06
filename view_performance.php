<?php
include 'db_conn.php';

// Fetch employees for the dropdown
$employees_result = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM employees");

// Initialize variables
$review_message = "";
$selected_employee = "";
$selected_month = "";
$selected_year = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = $_POST['employee_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    
    $selected_employee = $employee_id;
    $selected_month = $month;
    $selected_year = $year;

    // Query to get the review for the selected employee and month/year
    $stmt = $conn->prepare("SELECT description FROM employee_reviwes WHERE employee_id = ? AND MONTH(dateLogged) = ? AND YEAR(dateLogged) = ?");
    $stmt->bind_param("iii", $employee_id, $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the review if available
        $row = $result->fetch_assoc();
        $review_message = htmlspecialchars($row['description']);
    } else {
        // No review found message
        $review_message = "No review found for the specified month and year.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Employee Performance Review</title>
</head>
<body>

<h2>View Employee Performance Review</h2>

<form method="POST" action="">
    <label for="employee_id">Select Employee:</label>
    <select name="employee_id" id="employee_id" required>
        <option value="">-- Select an Employee --</option>
        <?php if ($employees_result->num_rows > 0): ?>
            <?php while($row = $employees_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $selected_employee) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($row['full_name']); ?>
                </option>
            <?php endwhile; ?>
        <?php endif; ?>
    </select>
    <br><br>

    <label for="month">Enter Month (1-12):</label>
    <input type="number" name="month" id="month" min="1" max="12" value="<?php echo $selected_month; ?>" required>
    <br><br>

    <label for="year">Enter Year:</label>
    <input type="number" name="year" id="year" min="2000" max="<?php echo date('Y'); ?>" value="<?php echo $selected_year; ?>" required>
    <br><br>

    <button type="submit">View Review</button>
</form>

<?php if (!empty($review_message)): ?>
    <h3>Performance Review:</h3>
    <p><?php echo $review_message; ?></p>
<?php endif; ?>

</body>
</html>
