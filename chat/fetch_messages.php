<?php
// Inclure le fichier de connexion à la base de données
require_once 'db.php';

// Récupérer l'ID de l'utilisateur actuel (par exemple à partir d'une session)
$user_id = $_SESSION['user_id']; // Assurez-vous d'avoir démarré la session si nécessaire

try {
    // Préparer la requête de sélection
    $stmt = $dbh->prepare("SELECT m.*, u.path_pp FROM messages m 
                           JOIN users u ON m.sent_by = u.id_USER 
                           WHERE m.sent_to = :user_id OR m.sent_by = :user_id
                           ORDER BY m.sent_at DESC
                           LIMIT 20");

    // Binder les paramètres
    $stmt->bindParam(':user_id', $user_id);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les résultats
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Répondre avec les messages au format JSON
    header('Content-Type: application/json');
    echo json_encode($messages);
} catch (PDOException $e) {
    // En cas d'erreur de base de données, afficher un message d'erreur
    echo "Erreur de récupération des messages : " . $e->getMessage();
    http_response_code(500); // Code d'erreur de serveur interne
}
?>
