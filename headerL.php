<?php
// session_start();
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/header.css" />
</head>

<header <?php if ($_SESSION['role'] == 'admin') echo 'class="admin"'; ?>>
    <div id="accueil">
        <a href="https://schoolpea.com/#SchoolPea">
            <img id="logo_header" src="https://schoolpea.com/Images/SchoolPea.png" />
        </a>
        <a href="https://schoolpea.com#SchoolPea"> SchoolPéa </a>
    </div>

    <div id="Pages">
        <span class="link">
            <a class="lien_header" href="https://schoolpea.com/SchoolPea+/">
                SchoolPea+
            </a>
        </span>

        <span class="link">
            <a href="https://schoolpea.com/Classement/" class="lien_header">
                Classement
            </a>
        </span>

        <span class="link">
            <a class="lien_header" href="https://schoolpea.com/Quizzs/">
                Explorer les Quizzs
            </a>
        </span>

        <span class="link">
            <a class="lien_header" href="https://schoolpea.com/Cours/">
                Explorer les Cours
            </a>
        </span>

        <span id="slide_down" class="link">
            <img src="https://schoolpea.com/Images/liste.svg" id="dropbtn">
            <div id="dropdown">
                <?php if ($_SESSION['role'] == 'admin') echo '<a class="lien_header" href="schoolpea.com/BackOffice">Back Office</a>'; ?>
                <a class="lien_header" href="schoolpea.com/Compte/">Mon compte</a>
                <a class="lien_header" href="schoolpea.com/Ticket/">Faire un ticket</a>
                <a class="lien_header" style="background-color:red; color: white;" href="/BackEnd/logout.php">Déconnexion</a>
            </div>
        </span>

        <span style="margin-left: 0rem; cursor: pointer;" class="link">
            <img src="https://schoolpea.com/<?php echo  $_SESSION['path_pp']; ?>" id="Photo_profile" onclick="location.replace('/Compte');" />
        </span>
    </div>
</header>