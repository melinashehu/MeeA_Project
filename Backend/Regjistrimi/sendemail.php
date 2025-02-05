<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/codding-community-platform/vendor/autoload.php';
require 'C:/xampp/htdocs/codding-community-platform/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/codding-community-platform/PHPMailer/src/SMTP.php';
require 'C:/xampp/htdocs/codding-community-platform/PHPMailer/src/Exception.php';

function sendVerificationEmail($email, $verificationCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = false; 
        $mail->isSMTP(); 
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;  
        $mail->Username   = 'meeanoreply@gmail.com';  
        $mail->Password   = 'fhtr vdfy wcxa ltut';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;   

       
        $mail->setFrom('meeanoreply@gmail.com', 'MEEA');
        $mail->addAddress($email); 
        
        $mail->isHTML(true);
        $mail->Subject = 'Verifikimi i Emailit';
        $mail->Body    = 'Urime! Jeni regjistruar me sukses. Përdorni kodin e mëposhtëm për të verifikuar llogarinë tuaj: ' . $verificationCode;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}