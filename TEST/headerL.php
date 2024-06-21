<?php
session_start();
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="./header.css" />
</head>

<header <?php if ($_SESSION['x'] == 5) echo 'class="admin"' ?>>
    <div id="accueil">
        <a href="#SchoolPea">
            <img id="logo_header" src="../Images/SchoolPea.png" />
        </a>
        <a href="#SchoolPea"> SchoolPéa </a>
    </div>
    <div id="Pages">

<<<<<<< HEAD
=======
        <span id="slide_down">
            <img src="../Images/liste.svg" id="dropbtn">
            <div id="dropdown">
                <a class="lien_header">Voir Plus</a>
                <a class="lien_header">Mon compte</a>
                <a class="lien_header">Paramètres</a>
            </div>
        </span>

>>>>>>> 11a8bc7 (up)
        <span>
            <a class="lien_header" href="accueilNL.php"> SchoolPea+ </a>
        </span>

        <span>
            <a class="lien_header" href="accueilNL.php">
                Explorer les Quizzs
            </a>
        </span>

        <span>
            <a class="lien_header" href="accueilNL.php">
                Explorer les Cours
            </a>
        </span>

        <span>
            <a class="lien_header" href="accueilNL.php">Mes Cours</a>
        </span>

<<<<<<< HEAD
        <span id="slide_down">
            <img src="../Images/liste.svg" id="dropbtn">
            <div id="dropdown">
                <a class="lien_header">Voir Plus</a>
                <a class="lien_header">Mon compte</a>
                <a class="lien_header">Paramètres</a>
            </div>
        </span>

=======
>>>>>>> 11a8bc7 (up)
        <span style="margin-left: 1.2rem">
            <img src="../Images/Luffy.jpg" id="Photo_profile" /> <!-- Aller chercher la photo de profile lié à l'utilisateur -->
        </span>
    </div>
</header>