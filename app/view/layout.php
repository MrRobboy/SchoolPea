<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schoolpéa</title>
    <link rel="stylesheet" href="<? echo CSS; ?>style.css" />
    <script src="<? echo JS; ?>script.js"></script>
</head>

<body>
    <header>
        <span id="accueil">
            <a href="#1">
                <img id="logo_header" src="../../../public/images/SchoolPea.png" alt="Logo" />
            </a>
            <a href="#SchoolPea">SchoolPéa</a>
        </span>

        <span id="Pages">
            <span>
                <a href="#Explorer_les_cours" class="lien_header">
                    Explorer les cours
                </a>
            </span>

            <span>
                <a href="../Inscription-Connexion/Connexion/index.html" class="lien_header">
                    Se Connecter
                </a>
            </span>

            <span>
                <a href="../Inscription-Connexion/Inscription/index.html" class="lien_header">
                    S'inscrire
                </a>
            </span>
        </span>
    </header>

    <!--Ma page -->
    <?php echo $contentPage; ?>

</body>

</html>