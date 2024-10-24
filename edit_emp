<?php
// Include your database connection file
include 'db_conn.php'; // Adjust the path if necessary

// Get the employee ID from the URL
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Query to fetch the employee's details
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $employee = $result->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit;
    }
} else {
    echo "No employee selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Edit Employee</h2>
        <form action="edit_emp_update.php" method="POST">
            <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo $employee['first_name']; ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo $employee['last_name']; ?>" required>

            <label for="position">Position:</label>
            <input type="text" name="position" id="position" value="<?php echo $employee['position']; ?>" required>

            <label for="hire_date">Hire Date:</label>
            <input type="date" name="hire_date" id="hire_date" value="<?php echo $employee['hire_date']; ?>" required>

            <label for="salary">Salary:</label>
            <input type="number" name="salary" id="salary" value="<?php echo $employee['salary']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $employee['email']; ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" value="<?php echo $employee['phone_number']; ?>" required>

            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo $employee['username']; ?>" required>

            <button type="submit">Update Employee</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
