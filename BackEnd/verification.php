<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';


function generateRandomCode($length = 6)
{
    $characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
    $code = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, $max)];
    }
    return $code;
}


function sendVerificationEmail($email, $verificationCode)
{

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'schoolpea@outlook.fr';
    $mail->Password = 'BienvenueEnLangageCLuffyNikaAroufGangstaXavierDupontDeLigones.exe'; // Mot de passe
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;


    $mail->setFrom('schoolpea@outlook.fr', 'SchoolPea');


    $mail->addAddress($email);


    $mail->isHTML(true);
    $mail->Subject = 'Verification d\'inscription';
    $mail->Body = 'Votre code de verification est : ' . $verificationCode;

   
    if ($mail->send()) {
     
        return true;
    } else {
       
        return false;
    }
}

$verificationCode = generateRandomCode();
sendVerificationEmail($_SESSION['email'], $verificationCode);
$_SESSION['verif'] = $verificationCode;
$_SESSION['mail_envoyee'] = 'oui';
header('Location: ./message_verification.php');
