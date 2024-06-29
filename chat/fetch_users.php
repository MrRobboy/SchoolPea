<?php
// Inclure le fichier de connexion à la base de données
require_once 'db.php';

try {
    // Préparer la requête de sélection
    $stmt = $dbh->prepare("SELECT * FROM users");

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les résultats
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Répondre avec les utilisateurs au format JSON
    header('Content-Type: application/json');
    echo json_encode($users);
} catch (PDOException $e) {
    // En cas d'erreur de base de données, afficher un message d'erreur
    echo "Erreur de récupération des utilisateurs : " . $e->getMessage();
    http_response_code(500); // Code d'erreur de serveur interne
}
?>
