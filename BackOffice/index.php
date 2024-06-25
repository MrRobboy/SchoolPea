<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

if (!$_SESSION['role'] == "admin") {
    $chemin = $_SERVER['DOCUMENT_ROOT'];
    header('Location: /');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - Tableau de Bord</title>
    <link rel="stylesheet" type="text/css" href="./backoffice.css">
</head>

<body>
    <div class="container">
        <h1>Tableau de Bord</h1>
        <div class="dashboard">
            <div class="dashboard-item">
                <a href="users/index.php">
                    <h2>Gestion des Utilisateurs</h2>
                    <p>Ajouter, modifier ou supprimer des utilisateurs</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="captcha/index.php">
                    <h2>Gestion du CAPTCHA</h2>
                    <p>Ajouter, modifier ou supprimer des questions CAPTCHA</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="newsletter/index.php">
                    <h2>Newsletter</h2>
                    <p>Envoyer des newsletters et consulter l'historique</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="logs/index.php">
                    <h2>Visualisation des Logs</h2>
                    <p>Consulter les logs des activités</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="tickets/index.php">
                    <h2>Gestion des Tickets</h2>
                    <p>Gérer les tickets utilisateur</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="courses/index.php">
                    <h2>Gestion des Cours</h2>
                    <p>Ajouter, modifier ou supprimer des cours</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="quizzes/index.php">
                    <h2>Gestion des Quizz</h2>
                    <p>Ajouter, modifier ou supprimer des quizz</p>
                </a>
            </div>
        </div>
    </div>
</body>

</html>