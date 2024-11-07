<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Send Email</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    input, textarea, button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    input, textarea {
        background-color: #f9f9f9;
    }

    button {
        background-color: #007bff; /* Primary button color */
        color: white;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }

    .message-box {
        margin: 15px 0;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
    }

    .success {
        background-color: #d4edda; /* Success message background */
        color: #155724;
    }

    .error {
        background-color: #f8d7da; /* Error message background */
        color: #721c24;
    }
  </style>
</head>
<body>
  <div class="container">
    <form action="" method="post">
      <h1>Send Email</h1>

      <?php if (!empty($statusMessage)): ?>
      <div class="message-box <?php echo $statusType; ?>">
        <?php echo $statusMessage; ?>
      </div>
      <?php endif; ?>

      <input type="email" name="recipient" placeholder="Recipient's Email" required>
      <textarea name="message" placeholder="Type your message here..." rows="5" required></textarea>
      <button type="submit" name="send">Send Email</button>
    </form>
  </div>

  <?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'phpmailer/src/Exception.php';
  require 'phpmailer/src/PHPMailer.php';
  require 'phpmailer/src/SMTP.php';

  $statusMessage = '';
  $statusType = '';

  if (isset($_POST["send"])) {
      $mail = new PHPMailer(true);

      try {
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com';
          $mail->SMTPAuth   = true;
          $mail->Username   = 'intranet193@gmail.com';      
          $mail->Password   = 'qnue lvmi bnwt ebep';       
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port       = 587;

          $mail->setFrom('intranet193@gmail.com', 'Intranet');      
          $mail->addReplyTo('intranet193@gmail.com', 'Intranet');
          $mail->addAddress($_POST["recipient"]);  

          $mail->isHTML(true);
          $mail->Subject = "Intranet System Notification";   
          $mail->Body    = nl2br(htmlspecialchars($_POST["message"])); 

          $mail->send();
          $statusMessage = "Message was sent successfully!";
          $statusType = "success";

          
          header("Location: ../HR_Management.php");
          exit(); 
      } catch (Exception $e) {
          $statusMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          $statusType = "error";
      }
  }
  ?>
</body>
</html>
