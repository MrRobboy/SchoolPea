<?php
session_start();
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Cours en ligne</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Bienvenue sur SchoolPea</h1>
    <a href="explorerLesCours.php">Explorer les cours</a>
    <a href="mesCours.php">Mes cours likés</a>
    <a href="creerCours.php">Créer un cours</a>
</body>
</html>
