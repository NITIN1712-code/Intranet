<?php
$to = "poonit012@gmail.com"; // Change to a valid email address
$subject = "Test Email";
$message = "This is a test email.";
$headers = "From: intranet193@gmail.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Failed to send email.";
}
?>
