<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $leaveDate = $_POST['leaveDate'];
    $leaveType = $_POST['leaveType'];
    $approval = $_POST['approval'];

    $sql = "INSERT INTO leaves (employee_id, leaveDate, leaveType, approval)
            VALUES ('$employee_id', '$leaveDate', '$leaveType', '$approval')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Leave request submitted successfully!');
                window.location.href = 'home.php'; // Redirect to home page
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

