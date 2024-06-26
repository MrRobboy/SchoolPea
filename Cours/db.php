<?php
$host = 'localhost'; // ou votre hôte de base de données
$dbname = 'PA';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO à exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit(); // Arrêter le script en cas d'erreur de connexion
}
