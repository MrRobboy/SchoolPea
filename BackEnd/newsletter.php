<?php

// Inclure les dépendances de PHPMailer
require 'vendor/autoload.php';

// Fonction pour envoyer une newsletter
function sendNewsletter($subject, $body) {
    // Configurer PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; // Serveur SMTP (exemple avec Outlook)
    $mail->SMTPAuth = true;
    $mail->Username = 'schoolpea@outlook.fr'; // Adresse e-mail
    $mail->Password = 'BienvenueEnLangageCLuffyNikaAroufGangstaXavierDupontDeLigones.exe'; // Mot de passe
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Expéditeur
    $mail->setFrom('schoolpea@outlook.fr', 'SchoolPea');

    // Contenu du message
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    // Envoyer l'e-mail
    if($mail->send()) {
        // Enregistrer l'envoi dans la base de données pour l'historique
        try {
            // Connexion à la base de données avec PDO
            $conn = new PDO("mysql:host=localhost;dbname=PA", "root", "root");
            // Configure PDO to throw exceptions
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparation de la requête SQL pour insérer les détails de l'e-mail envoyé dans la table 'newsletter_history'
            $sql = "INSERT INTO newsletter_history (subject, body, sent_at) VALUES (:subject, :body, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':body', $body);
            $stmt->execute();


            return true;
        } catch(PDOException $e) {
            // Une erreur s'est produite lors de l'enregistrement de l'e-mail dans la base de données

            // Afficherl'erreur
            echo "Error: " . $e->getMessage();


            return false;
        }
    } else {
        return false;
    }
}

// Exemple d'utilisation
$subject = "Tu commences a nous manqué";
$body = "stp reviens tu commences a nous manqué ";
if(sendNewsletter($subject, $body)) {
    echo 'Newsletter envoyée avec succès';
} else {
    echo 'Erreur lors de l\'envoi de la newsletter';
}

?>
