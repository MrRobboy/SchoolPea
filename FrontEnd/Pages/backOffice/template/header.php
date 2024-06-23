<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/FrontEnd/Pages/backOffice/template/header.css" />
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="roles/index.php">Rôles</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
</body>

<header class="admin">
    <div id="accueil">
        <a href="#SchoolPea">
            <img id="logo_header" src="https://schoolpea.com/Images/SchoolPea.png" />
        </a>
        <a href="#SchoolPea"> SchoolPéa </a>
    </div>

    <div id="Pages">
        <span>
            <a class="lien_header" href="Utilisateurs.php"> Utilisateurs</a>
        </span>

        <span>
            <a class="lien_header" href="Logs.php">Logs</a>
        </span>

        <span>
            <a class="lien_header" href="Captcha">Captcha</a>
        </span>

        <span>
            <a class="lien_header" href="Captcha">Paramètres</a>
        </span>

        <span>
            <a class="lien_header" href="https://schoolpea.com/">Front Office</a>
        </span>

        <span id="slide_down">
            <img src="https://schoolpea.com/Images/listeA.svg" id="dropbtn">
            <div id="dropdown">
                <a class="lien_header" href="https://schoolpea.com/Tickets/">Tickets</a>
                <a class="lien_header" href="https://schoolpea.com/">Front Office</a>
                <a class="lien_header" href="https://schoolpea.com/Compte/">Paramètres</a>
            </div>
        </span>

        <span style="margin-left: 1.2rem">
            <img src="<?php echo ($_SERVER['DOCUMENT_ROOT'] . $_SESSION['pp_path']); ?>" id="Photo_profile" /> <!-- Aller chercher la photo de profile lié à l'utilisateur -->
        </span>
    </div>
</header>