<?php
// send_message.php

session_start(); // Démarrer la session PHP

include 'db.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le message à partir des données POST
    $message = $_POST['message'];

    // Récupérer l'ID de l'utilisateur à partir de la session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Préparer la requête d'insertion avec PDO
        $stmt = $dbh->prepare("INSERT INTO messages (message, users_id) VALUES (:message, :user_id)");

        // Binder les paramètres
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':user_id', $user_id);

        // Exécuter la requête
        try {
            $stmt->execute();
            echo "Message envoyé avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion du message: " . $e->getMessage();
        }
    } else {
        echo "Erreur: ID utilisateur non trouvé dans la session.";
    }
}
?>
