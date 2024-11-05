<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $employee_id = $_POST['employee_id'];
    $leaveDate = $_POST['leaveDate'];
    $leaveType = $_POST['leaveType'];
    $approval = 1; // Setting approval as 1 for "approved" or 0 for "not approved" based on your business logic

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO leaves (employee_id, leaveDate, leaveType, approval) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $employee_id, $leaveDate, $leaveType, $approval);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "<script>
                alert('Leave request submitted successfully!');
                window.location.href = 'home.php'; // Redirect to home page
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>


