<?php
include 'db_conn.php';
$leave_id = $_GET['leave_id'];

$sql = "SELECT employee_id FROM leaves WHERE leave_id = '$leave_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$employee_id = $row['employee_id'];

$sqlEmail = "SELECT email FROM employees WHERE id = '$employee_id'";
$resultEmail = $conn->query($sqlEmail);
$rowEmail = $resultEmail->fetch_assoc();
$email = $rowEmail['email'];

$sqlApprove = "UPDATE leaves SET approval = 'Approved' WHERE leave_id = '$leave_id'";
if ($conn->query($sqlApprove) === TRUE) {
   
    $subject = "Leave Request Approved";
    $message = "Your leave request has been approved.";
    $headers = "From: no-reply@yourdomain.com";

    mail($email, $subject, $message, $headers);
    echo "Leave request approved and email sent.";
} else {
    echo "Error approving leave request: " . $conn->error;
}

$conn->close();
?>
