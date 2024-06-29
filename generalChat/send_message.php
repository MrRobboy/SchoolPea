<?php
session_start();
include 'db.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    
    $sql = "INSERT INTO MESSAGE (sent_by, message) VALUES (:user_id, :content)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        echo "Message envoyé avec succès.";
    } else {
        echo "Erreur: " . $stmt->errorInfo()[2];
    }

    // Fermer la connexion PDO
    $stmt = null;
    $dbh = null;
}
?>
