<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/header.css" />
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <style>
        /* Styles spécifiques pour l'en-tête */
        header {
            /* Vos styles pour l'en-tête ici */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('dark-mode-checkbox');

            checkbox.addEventListener('change', function () {
                if (checkbox.checked) {
                    document.body.classList.add('dark-mode');
                } else {
                    document.body.classList.remove('dark-mode');
                }
            });
        });
    </script>
</head>

<body>
    <header <?php if ($_SESSION['role'] == 'admin') echo 'class="admin"'; ?> <?php if ($_SESSION['role'] == 'prof') echo 'class="prof"'; ?>>
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

            <span id="slide_down">
                <img src="https://schoolpea.com/Images/liste.svg" id="dropbtn">
                <div id="dropdown">
                    <?php if ($_SESSION['role'] == 'admin') echo '<a class="lien_header" href="https://schoolpea.com/BackOffice/">Back Office</a>'; ?>
                    <a class="lien_header" href="https://schoolpea.com/Compte/">Mon compte</a>
                    <a class="lien_header" href="https://schoolpea.com/Tickets/">Faire un ticket</a>
                    <a class="lien_header" href="https://schoolpea.com/Chat/">Chat</a>
                    <?php if ($_SESSION['role'] == 'prof') echo '<a class="lien_header" href="https://schoolpea.com/Cours/creerCours.php">Créer un Cours</a>'; ?>
                    <?php if ($_SESSION['role'] == 'prof') echo '<a class="lien_header" href="https://schoolpea.com/Quizzs/createQuizz.php">Créer un Quizz</a>'; ?>
                    <a class="lien_header" style="background-color:red; color: white;" href="https://schoolpea.com/BackEnd/logout.php">Déconnexion</a>
                </div>
            </span>

            <span style="margin-left: 0rem; cursor: pointer;" id="span_photo">
                <img src="<?php echo $_SESSION['path_pp']; ?>" id="Photo_profile" onclick="location.replace('/Compte');" />
            </span>

            <!-- Ajout du bouton pour activer le mode sombre -->
            <div id="dark-mode-toggle">
                <input type="checkbox" id="dark-mode-checkbox">
                <label for="dark-mode-checkbox">Mode sombre</label>
            </div>
        </div>
    </header>
</body>

</html>
