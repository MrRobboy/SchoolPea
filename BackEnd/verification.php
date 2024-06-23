<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Inclure les dépendances de PHPMailer
require 'vendor/autoload.php';
require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';

// Fonction pour générer un code de vérification aléatoire
function generateRandomCode($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, $max)];
    }
    return $code;
}

// Fonction pour envoyer un e-mail de vérification d'inscription
function sendVerificationEmail($email, $verificationCode)
{
    // Configurer PHPMailer
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; // Serveur SMTP (exemple avec Outlook)
    $mail->SMTPAuth = true;
    $mail->Username = 'schoolpea@outlook.fr'; // Adresse e-mail
    $mail->Password = 'BienvenueEnLangageCLuffyNikaAroufGangstaXavierDupontDeLigones.exe'; // Mot de passe
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Expéditeur
    $mail->setFrom('schoolpea@outlook.fr', 'SchoolPea');

    // Destinataire
    $mail->addAddress($email);

    // Contenu du message
    $mail->isHTML(true);
    $mail->Subject = 'Verification d\'inscription';
    $mail->Body = 'Votre code de vérification est : ' . $verificationCode;

    // Envoyer l'e-mail
    if ($mail->send()) {
        // Succès
        return true;
    } else {
        // Échec
        return false;
    }
}

sendVerificationEmail($_SESSION['email'], generateRandomCode());
$_SESSION['verif'] = $verificationCode;
$_SESSION['mail_envoyee'] = 'oui';
// header('Location: ' . $_SERVER['HTTP_REFERER']);
