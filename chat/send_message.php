<?php
session_start(); // Démarre la session si ce n'est pas déjà fait

$host = 'localhost';
$dbname = 'PA';
$username = 'root';
$password = 'root';

// Récupérer le message envoyé depuis le formulaire
$message = $_POST['message'];

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'ID de l'utilisateur actuel (vous devrez implémenter l'authentification)
    $userId = $_SESSION['user_id']; // À remplacer par la méthode d'authentification appropriée

    // Insérer le message dans la table MESSAGE
    $stmt = $dbh->prepare("INSERT INTO MESSAGE (message, sent_by) VALUES (:message, :sent_by)");
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':sent_by', $userId);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
