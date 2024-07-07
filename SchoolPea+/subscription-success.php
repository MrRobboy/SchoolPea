<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= 'BackEnd/db.php';
include($path);

$dbh->exec('USE PA');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription réussite </title>
    <style>
        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            font-family: "Montserrat", sans-serif;
            transition: all 0.3s, color 0.3s;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #c9d6ff;
            border-radius: 5px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            background-color: #4f4cf5;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bienvenu a toi nouvel adherant </h1>
        <p>Vous vous êtes abonné avec succès à SchoolPea. Un email de confirmation vous a été envoyé.</p>
        <p>Clique sur le bouton pour revenir a la page d'accueil </p>
        <a href="https://schoolpea.com" class="button">Retour a l'accueil </a>
    </div>
</body>

</html>