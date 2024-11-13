<?php

require 'db_conn.php'; 


 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 require 'PhpMailer/src/PHPMailer.php';
 require 'PhpMailer/src/SMTP.php';
 require 'PhpMailer/src/Exception.php';

$leave_request_id = $_GET['leave_id']; 


$query = "UPDATE leaves SET approval = 1 WHERE leave_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $leave_request_id);
$stmt->execute();


$query = "SELECT email 
          FROM employees 
          JOIN leaves ON employees.id = leaves.employee_id 
          WHERE leaves.leave_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $leave_request_id);
$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows > 0) {
    $stmt->bind_result($email);
    $stmt->fetch();


    $mail = new PHPMailer(true);
    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'intranet193@gmail.com';
        $mail->Password = 'qnue lvmi bnwt ebep';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('intranet193@gmail.com', 'Intranet');

        $mail->addAddress($email);

        $mail->Subject = 'Leave Request Approved';
        $mail->Body    = 'Your leave request has been approved.';

        if ($mail->send()) {
            echo 'Leave request approved, and email sent to applicant!';
        } else {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'No email found for this leave request ID.';
}

$stmt->close();
$conn->close();
?>
