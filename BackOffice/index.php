<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
echo ('<pre>');
print_r($_SESSION);
echo ('</pre>');
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
                <a href="https://schoolpea.com/BackOffice/User">
                    <h2>Gestion des Utilisateurs</h2>
                    <p>Ajouter, modifier ou supprimer des utilisateurs</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="https://schoolpea.com/BackOffice/Captcha">
                    <h2>Gestion du CAPTCHA</h2>
                    <p>Ajouter, modifier ou supprimer des questions CAPTCHA</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="https://schoolpea.com/BackOffice/Newsletter">
                    <h2>Newsletter</h2>
                    <p>Envoyer des newsletters et consulter l'historique</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="https://schoolpea.com/BackOffice/Logs">
                    <h2>Visualisation des Logs</h2>
                    <p>Consulter les logs des activités</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="https://schoolpea.com/BackOffice/Tickets">
                    <h2>Gestion des Tickets</h2>
                    <p>Gérer les tickets utilisateur</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="https://schoolpea.com/BackOffice/Cours">
                    <h2>Gestion des Cours</h2>
                    <p>Ajouter, modifier ou supprimer des cours</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="https://schoolpea.com/BackOffice/Quizz">
                    <h2>Gestion des Quizz</h2>
                    <p>Ajouter, modifier ou supprimer des quizz</p>
                </a>
            </div>
            <div class="front-office">
                <a href="https://schoolpea.com/">
                    <h2>Front-Office</h2>
                    <p>Retourner à la page d'accueil</p>
                </a>
            </div>
        </div>
    </div>
</body>

</html>