<?php
// Include the database connection file
include 'db_conn.php';

// Check if the employee ID is set
if (isset($_POST['employee_id']) && !empty($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $employee_id);

    if ($stmt->execute()) {
        echo "Employee deleted successfully.";
    } else {
        echo "Error deleting employee: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "No employee selected.";
}

// Close the database connection
$conn->close();
?>
