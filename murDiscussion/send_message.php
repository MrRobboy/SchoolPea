<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die('Utilisateur non connecté.');
}

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

    // Récupérer l'ID de l'utilisateur connecté depuis la session
    $user_id = $_SESSION['user_id'];
    $message = $_POST['message']; // Message

    // Préparer la requête d'insertion
    $sql = "INSERT INTO messages (user_id, message, created_at) VALUES (:user_id, :message, NOW())";
    $stmt = $pdo->prepare($sql);

    // Lier les paramètres
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Rediriger vers la page principale pour afficher les messages
    header("Location: index.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermer la connexion PDO
$pdo = null;
?>
