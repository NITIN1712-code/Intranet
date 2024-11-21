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
$nsf = (float)$_POST["NSF"];
$csg = (float)$_POST["CSG"];
$prgf = (float)$_POST["prgf"];
$ccsg = (float)$_POST["CCSG"];
$cnsf = (float)$_POST["CNSF"];
$address = (string)$_POST["address"];
$salary_base = (float)$_POST["salary_base"];
$position = (string)$_POST["position"];
$category = (string)$_POST["category"];
$dept_name = (string)$_POST["dept_name"];
$travel_cost = (float)$_POST["travel_cost"];
$ban = (string)$_POST["bank_account_number"];



$mail = new PHPMailer(true);

try {
    $results = $conn->query("INSERT INTO payrolls(employee_id, paymentAmount, payment_date, CCsg, CNsf, prgf, csg, nsf, address, salary_base, position, dept_name, travel_cost, bank_account_number,category) 
    VALUES(".$id.",".$pay_amount.",'".$date."',".$ccsg.",".$cnsf.",".$prgf.",".$csg.",".$nsf.",'".$address."',".$salary_base.",'".$position."','".$dept_name."',".$travel_cost.",'".$ban."','".$category."')");


    
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

        $jsonData = json_decode(file_get_contents("settings.JSON"),true);



        $mail->AddAttachment($jsonData["download_path"]."\\".$file_name);

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