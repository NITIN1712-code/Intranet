<?php

require("db_conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PhpMailer/phpmailer/src/Exception.php';
require 'PhpMailer/phpmailer/src/PHPMailer.php';
require 'PhpMailer/phpmailer/src/SMTP.php';

$file_name = $_POST["doc"];
$id = (int)$_POST["id"];
$pay_amount = (float)$_POST["pay_amount"];
$date = (string)$_POST["date"];


$mail = new PHPMailer(true);

try {
    $results = $conn->query("INSERT INTO payrolls(employee_id, paymentAmount, date) VALUES(".$id.",".$pay_amount.",'".$date."')");


    
    if($results){
        $res = $conn->query("SELECT email FROM employees WHERE id =".$id);

        $row = $res->fetch_assoc();

        $email = $row["email"];

        $mail->SMTPDebug = SMTP::DEBUG_OFF;                       
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                               
        $mail->Username   = 'intranet193@gmail.com';            
        $mail->Password   = 'qnue lvmi bnwt ebep';                
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     
        $mail->Port       = 587;                                

        $mail->setFrom('intranet193@gmail.com', 'Intranet');      
        $mail->addAddress($email, ''); 

        $mail->isHTML(true);                                    
        $mail->Subject = 'Payslip';                  
        $mail->Body    = "Payslip";

        sleep(1);

        $mail->AddAttachment("".$file_name);

        if ($mail->send()) {
            echo "Message has been sent";
        } else {
            echo "Message could not be sent.";
        }
    }else{
        echo "error";
    }
} catch(Exception) {
    echo "error";
}



$conn->close();

?>