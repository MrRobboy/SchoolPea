<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Mon compte</title>
    <link rel="stylesheet" type="text/css" href="../Styles/compte.css" />
</head>


<body>
    <header>
        <div id="accueil">

            <img id="logo_header" src="../Images/SchoolPea.png" />
            </a>
            <a href="#SchoolPea"> SchoolPéa </a>
        </div>
        <div id="Pages">
            <span>
                <a class="lien_header" href="./index.html"> SchoolPea+ </a>
            </span>
            <span>
                <a class="lien_header" href="./index.html">
                    Explorer les Quizzs
                </a>
            </span>
            <span>
                <a class="lien_header" href="./index.html">
                    Explorer les Cours
                </a>
            </span>
            <span>
                <a class="lien_header" href="./index.html">Mes Cours</a>
            </span>

            <span id="slide_down">
                <img src="../Images/liste.svg" style="width: 32px;">
                <div>
                    <a>Voir Plus</a>
                    <a>Mon compte</a>
                    <a>Paramètres</a>
                </div>
            </span>

            <span style="margin-left: 1.2rem">
                <img src="../Images/PP_TEST.jpg" style="width: 45px; border-radius: 50%" />
            </span>
        </div>
    </header>

    <span class="trait"></span>

    <div id="div1">
        <span id="Info_gen">
            <span id="1,1,ligne1">
                <img src="../Images/reglage.svg" style="width: 45px;">
                <h1>Informations Générales</h1>
            </span>

            <span id="1,1,ligne2">
                <img src="../Images/Luffy.jpg" id="Photo_profile">
                <button>Changer l'image</button>
            </span>

            <span id="1,1,ligne3">
                <span id="1,1,3,col1">
                    <span id="1,1,3,1,ligne1">ligne 1</span>
                    <span id="1,1,3,1,ligne2">ligne 2</span>
                </span>

                <span id="1,1,3,col2">
                    <span id="1,1,3,2,ligne1">ligne 1</span>
                    <span id="1,1,3,2,ligne2">ligne 2</span>
                </span>
            </span>

            <span id="1,1,ligne4">
                <span id="1,1,4,ligne1">ligne 1</span>
                <span id="1,1,4,ligne2">ligne 2</span>
            </span>

            <span id="1,1,ligne5">
                <button>Sauvegarder col1</button>
            </span>
        </span>

        <span id="Mdp_modif">
            <h2>TITRE</h2>
            <span id="1,2,ligne1">
                <span id="1,2,1,ligne1">ligne 1</span>
                <span id="1,2,1,ligne2">ligne 2</span>
            </span>

            <span id="1,2,ligne2">
                <span id="1,2,2,ligne1">ligne 1</span>
                <span id="1,2,2,ligne2">ligne 2</span>
            </span>

            <span id="1,2,ligne3">
                <span id="1,2,3,ligne1">ligne 1</span>
                <span id="1,2,3,ligne2">ligne 2</span>
            </span>
            <button>Sauvegarde col2</button>
        </span>
    </div>

    <div id="div2">
        <div style="padding: 2em;">
            <span id="2,ligne1" style="display: flex; flex-direction: row;">
                <span id="2,1,col1">
                    <img src="../Images/exclamation.svg" style="width: 45px; margin-top: 0.5em;">
                </span>

                <span id="2,1,col2" style="display: flex; flex-direction: column;">
                    <span style="padding: 1em 0 0.5em 1em; font-size: 1.2em; font-weight: 700;">Supprimer votre compte</span>
                    <span style=" padding: 1em;">Si vous supprimez votre compte, vous en perdrez l'accès définitif sans possibilité de le récupérer.<br> Vos données personnelles et vos progrès seront effacés et perdus, de même que tout abonnement en cours.</span>
                </span>
            </span>

            <span id="2,ligne2">
                <button>Supprimer le compte</button>
            </span>
        </div>
    </div>
</body>