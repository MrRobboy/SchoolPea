<?php
header('Content-Type: application/json');

// Informations de connexion à la base de données
$host = 'localhost'; // Adresse du serveur de base de données
$dbname = 'PA'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur
$password = 'root'; // Mot de passe

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Configuration de PDO pour lancer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer et exécuter la requête pour récupérer les messages
    $sql = "SELECT user_id, message, created_at, path_pp, firstname, lastname, email FROM messages JOIN users ON messages.user_id = users.id ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Récupérer les messages
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir les messages en JSON et les envoyer au client
    echo json_encode($messages);

} catch (PDOException $e) {
    // Retourner un code HTTP 500 en cas d'erreur serveur
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

// Fermer la connexion PDO
$pdo = null;
?>
