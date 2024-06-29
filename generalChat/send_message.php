<?php
session_start();
include 'db.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];

    // Insérer le message dans la base de données
    $sql = "INSERT INTO MESSAGE (sent_by, message) VALUES (?, ?)";
    $stmt = $dbh->prepare($sql);
    
    if ($stmt->execute([$user_id, $content])) {
        echo "Message envoyé avec succès.";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }

    // Fermer la connexion PDO
    $stmt = null;
    $dbh = null;
}
?>
