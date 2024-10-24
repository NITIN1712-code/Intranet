<?php
// Include your database connection file
include 'db_conn.php'; // Make sure 'db_conn.php' is correctly set up

// Query to select all employees
$sql = "SELECT id, first_name, last_name FROM employees";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching employees: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Delete Employee</h2>
        <form action="delete_emp_process.php" method="POST">
            <label for="employee_id">Select Employee to Delete:</label>
            <select name="employee_id" id="employee_id" required>
                <option value="">--Select Employee--</option>
                <?php
                // Populate the dropdown with employee data
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['first_name']} {$row['last_name']}</option>";
                    }
                } else {
                    echo "<option value=''>No employees found</option>";
                }
                ?>
            </select>
            <button type="submit">Delete Employee</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
