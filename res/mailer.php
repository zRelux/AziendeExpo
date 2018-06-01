<?php
class Mailer{

  static function email($to, $subject, $body){
    require("PHPMailer-master/src/SMTP.php");
    require("PHPMailer-master/src/Exception.php");
    require('PHPMailer-master/src/PHPMailer.php');

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "aziendeexpo@gmail.com";
    $mail->Password = "mostralatuazienda";
    $mail->setFrom('aziendeexpo@gmail.com', 'Aziende Expo');
    $mail->addAddress($to, $to);
    $mail->addCustomHeader("Content-type", "text/html");
    $mail->Subject = $subject;
    $mail->Body    = $body;

    if (!$mail->send()) {
      echo "Error sending message";
    }
  }
}
?>
