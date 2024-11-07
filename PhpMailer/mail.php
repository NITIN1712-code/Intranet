<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

$fname = "Recipient"; 
$passcode = "123456"; 
$use_date = "2024-11-30"; 

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                       
    $mail->isSMTP();                                          
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                               
    $mail->Username   = 'intranet193@gmail.com';            
    $mail->Password   = 'qnue lvmi bnwt ebep';                
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     
    $mail->Port       = 587;                                

    $mail->setFrom('intranet193@gmail.com', 'Intranet');      
    $mail->addAddress('poonit012@gmail.com', 'Recipient Name'); 

    $mail->isHTML(true);                                    
    $mail->Subject = 'YOU ARE FIRED';                  
    $mail->Body    = "Hello $fname! Your Passcode for the one day pass purchased is <br><br> 
                      <b>$passcode</b><br><br>
                      Date to use: $use_date <br><br>
                      Thank you for your visit!";

    if ($mail->send()) {
        echo "Message has been sent";
    } else {
        echo "Message could not be sent.";
    }
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}"; 
}
