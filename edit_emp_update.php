<?php
// Include your database connection file
include 'db_conn.php'; // Adjust the path if necessary

// Get the data from the POST request
$employee_id = $_POST['employee_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$position = $_POST['position'];
$hire_date = $_POST['hire_date'];
$salary = $_POST['salary'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$username = $_POST['username'];

// Prepare the SQL statement to update the employee
$sql = "UPDATE employees SET first_name = ?, last_name = ?, position = ?, hire_date = ?, salary = ?, email = ?, phone_number = ?, username = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssdissi", $first_name, $last_name, $position, $hire_date, $salary, $email, $phone_number, $username, $employee_id);

if ($stmt->execute()) {
    echo "Employee updated successfully";
} else {
    echo "Error updating employee: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
