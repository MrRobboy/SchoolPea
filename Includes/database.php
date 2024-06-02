<?php
$host = 'localhost';
$dbname = 'PA';
$username = 'root';
$password = 'root';
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $bdd = new PDO("mysql:host=localhost;dbname=PA", $username, $password, $options);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*echo "Connexion Reussie ";*/
} catch (PDOException $e) {
    echo "Erreur Connexion " . $e->getMessage();
    die;
}
