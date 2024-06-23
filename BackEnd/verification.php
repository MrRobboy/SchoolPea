<?php

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
    $mail->Subject = 'Vérification d\'inscription';
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

echo ('Bonjour');
sendVerificationEmail('mr.elattar.hicham@gmail.com', '123456');
// Vérifier si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'e-mail de l'utilisateur depuis le formulaire
    $email = $_POST['email'];

    // Générer un code de vérification aléatoire
    $verificationCode = generateRandomCode();

    // Envoyer l'e-mail de vérification d'inscription
    if (sendVerificationEmail($email, $verificationCode)) {
        // L'e-mail a été envoyé avec succès
        echo 'Un e-mail de vérification a été envoyé à ' . $email . '. Veuillez vérifier votre boîte de réception.';
    } else {
        // Une erreur s'est produite lors de l'envoi de l'e-mail
        echo 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail de vérification. Veuillez réessayer plus tard.';
    }
}
