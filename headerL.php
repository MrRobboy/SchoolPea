<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include_once($path);
$request = $dbh->query('SELECT * FROM USER WHERE email = :email;');
$queryStatement->bindvalue(':email', $_SESSION['email']);
$infos = $request->fetchAll();
$_SESSION['path_pp'] = $infos[0]['path_pp'];

?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/header.css" />
</head>

<header>
    <div id="accueil">
        <a href="#SchoolPea">
            <img id="logo_header" src="https://schoolpea.com/Images/SchoolPea.png" />
        </a>
        <a href="#SchoolPea"> SchoolPéa </a>
    </div>

    <div id="Pages">
        <span>
            <a class="lien_header" href="https://schoolpea.com/SchoolPea+/"> SchoolPea+ </a>
        </span>

        <span>
            <a class="lien_header" href="https://schoolpea.com/Quizzs/">
                Explorer les Quizzs
            </a>
        </span>

        <span>
            <a class="lien_header" href="https://schoolpea.com/Cours/">
                Explorer les Cours
            </a>
        </span>

        <span id="slide_down">
            <img src="https://schoolpea.com/Images/liste.svg" id="dropbtn">
            <div id="dropdown">
                <a class="lien_header">Voir Plus</a>
                <a class="lien_header">Mon compte</a>
                <a class="lien_header">Paramètres</a>
            </div>
        </span>

        <span style="margin-left: 1.2rem">
            <img src="<?php echo ($_SERVER['DOCUMENT_ROOT'] . $_SESSION['path_pp']); ?>" id="Photo_profile" /> <!-- Aller chercher la photo de profile lié à l'utilisateur -->
        </span>
    </div>
</header>