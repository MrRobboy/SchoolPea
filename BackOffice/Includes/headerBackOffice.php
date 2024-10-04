<?php
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/BackOffice/Includes/headerBackOffice.css" />
</head>

<header>
    <span id="accueil">
        <a href="https://schoolpea.com/BackOffice">
            <img id="logo_header" src="https://schoolpea.com/Images/SchoolPea.png" alt="Logo" />
        </a>
        <a href="https://schoolpea.com/BackOffice/">SchoolPéa</a>
    </span>

    <span id="Pages">
        <span class="link">
            <a href="https://schoolpea.com/BackOffice/User" class="lien_header">
                User
            </a>
        </span>

        <span class="link">
            <a href="https://schoolpea.com/BackOffice/Captcha" class="lien_header">
                Captcha
            </a>
        </span>

        <span class="link">
            <a href="https://schoolpea.com/BackOffice/Logs" class="lien_header">
                Logs
            </a>
        </span>

        <span class="link">
            <a href="https://schoolpea.com/BackOffice/Cours" class="lien_header">
                Cours
            </a>
        </span>

        <span class="link">
            <a href="https://schoolpea.com/BackOffice/Quizz" class="lien_header">
                Quizz
            </a>
        </span>
    </span>

    <span id="Front">
        <a href="https://schoolpea.com/" class="lien_header front">
            Front-office
        </a>
    </span>
</header>
