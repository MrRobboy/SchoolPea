<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../BackEnd/vendor/autoload.php';

function sendWelcomeEmail($recipientEmail) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com'; // Serveur SMTP (exmple avec Outlook)
        $mail->SMTPAuth = true;
        $mail->Username = 'schoolpea@outlook.fr'; // Adresse e-mail
        $mail->Password = 'BienvenueEnLangageCLuffyNikaAroufGangstaXavierDupontDeLigones.exe'; // Mot de passe
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('schoolpea@outlook.fr', 'SchoolPea');
        $mail->addAddress($recipientEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Bienvenu dans SchoolPea + !';
        $mail->Body    = 'Merci pour votre adhésion. A préésent vous pouvez pleinement profiter de toutes les fonctionnalités de schoolPea !
                            Apprend et fais apprendre sans limite car tu viens de débloquer la possibilité de crée autant de Cours et de Quizz que tu le souhaite ! ';

        $mail->send();
    } catch (Exception $e) {
        error_log("Probleme d'envoi du message {$mail->ErrorInfo}");
    }
}
