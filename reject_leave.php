<?php
include 'db_conn.php';

if (isset($_GET['leave_id'])) {
    $leave_id = $_GET['leave_id'];

    $sql = "DELETE FROM leaves WHERE leave_id = '$leave_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_leave_requests.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

