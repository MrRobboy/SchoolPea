<?php
// Inclure le fichier de connexion à la base de données
require_once 'db.php';

// Récupérer les données du formulaire (dans un environnement réel, vous devrez valider et échapper ces données)
$message = $_POST['message'];
$sent_by = $_POST['sent_by'];
$sent_to = $_POST['sent_to'];
$profile_picture = $_POST['profile_picture']; // Si nécessaire

try {
    // Préparer la requête d'insertion
    $stmt = $dbh->prepare("INSERT INTO messages (message, sent_by, sent_to, profile_picture) VALUES (:message, :sent_by, :sent_to, :profile_picture)");

    // Binder les paramètres
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':sent_by', $sent_by);
    $stmt->bindParam(':sent_to', $sent_to);
    $stmt->bindParam(':profile_picture', $profile_picture); // Si nécessaire

    // Exécuter la requête
    $stmt->execute();

    // Répondre avec succès (ou gérer les erreurs si nécessaire)
    http_response_code(200);
} catch (PDOException $e) {
    // En cas d'erreur de base de données, afficher un message d'erreur
    echo "Erreur d'envoi de message : " . $e->getMessage();
    http_response_code(500); // Code d'erreur de serveur interne
}
?>
