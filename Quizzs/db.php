<?php
$dsn = 'mysql:host=localhost;dbname=PA;charset=utf8mb4';
$username = 'root';
$password = 'root';

// Create a new PDO instance
try {
    $dbh = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer les exceptions PDO
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Désactiver l'émulation des requêtes préparées
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
