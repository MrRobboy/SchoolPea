<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schoolpéa</title>
    <link rel="stylesheet" href="<?echo CSS;?>style.css" />
    <script src="<?echo JS;?>script.js"></script>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
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
<?php echo $contentPage;?>

    <footer>
        <div class="footer">
            <span class="col1">
                <h3>
                    <a href="#SchoolPea" style="
                                color: white;
                                text-decoration: none;
                                font-weight: bolder;
                            ">
                        SchoolPéa
                    </a>
                </h3>
            </span>

            <span class="col2">
                <h4>Schoolpéa</h4>
                <a>Accueil</a>
                <a>A propos</a>
            </span>

            <span class="col3">
                <h4>Contact</h4>
                <a>E-mail</a>
                <a>Linkedin</a>
                <a>Instagram</a>
            </span>

            <span class="col4">
                <h4>Newsletter</h4>
                <a>Api fetch à Implémenter <br />Input email</a>
            </span>
        </div>
</footer>


</body>

</html>