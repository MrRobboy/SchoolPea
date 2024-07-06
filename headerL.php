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

        /* Styles pour le toggle switch */
        .toggle-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }

        .toggle-label {
            margin-right: 10px;
            cursor: pointer;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #3f51b5;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }

        /* Styles spécifiques pour le mode sombre */
        body.dark-mode {
            background-color: #333;
            color: #fff;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleSwitch = document.getElementById('dark-mode-toggle');

            // Vérifie le localStorage pour l'état du mode sombre
            if (localStorage.getItem('dark-mode') === 'enabled') {
                document.body.classList.add('dark-mode');
                toggleSwitch.checked = true;
            }

            toggleSwitch.addEventListener('change', function () {
                if (toggleSwitch.checked) {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('dark-mode', 'enabled');
                } else {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('dark-mode', 'disabled');
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

            <!-- Toggle switch pour le mode sombre -->
            <div class="toggle-container">
                <label class="toggle-label">Mode sombre</label>
                <label class="toggle-switch">
                    <input type="checkbox" id="dark-mode-toggle">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
    </header>
</body>

</html>
