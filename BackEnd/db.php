<?php

$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $bdd = new PDO("mysql:host=localhost;dbaname=PA", "root", "root");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion Reussie<br> ";
} catch (PDOException $e) {
    echo "Erreur Connexion " . $e->getMessage();
    die;
}
