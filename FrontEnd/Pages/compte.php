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
            <span id="Titre_Info_gen">
                <img src="../Images/reglage.svg" style="width: 45px;">
                <h1 style="margin-left: 0.5em;">Informations Générales</h1>
            </span>

            <span id="Modif_Photo">
                <img src="../Images/Luffy.jpg" id="Photo_profile">
                <button id="But_Photo">Charger une photo</button>
            </span>

            <span id="Modif_Nom_Prenom">
                <span id="Nom">
                    <span id="Text_Nom_Prenom_Email">Nom</span>
                    <input type="text" placeholder="Changer le nom" id="Input_Nom_Prenom_Email">
                </span>

                <span id="Prenom">
                    <span id="Text_Nom_Prenom_Email">Prénom</span>
                    <input type="text" placeholder="Changer le prénom" id="Input_Nom_Prenom_Email">
                </span>
            </span>

            <span id="Email">
                <span id="Text_Nom_Prenom_Email">Email adresse</span>
                <input type=" text" placeholder="Changer l'email" id="Input_Nom_Prenom_Email">
            </span>

            <span style="margin: 1em 0;">
                <input type="submit" id="Sauvegarde_modif" value="Sauvegarder Les modifications"></input>
            </span>
        </span>

        <span id="Mdp_modif">
            <h2 style="text-align: center; font-weight: 700; font-size: 150%;"> Changer de <br> Mot de passe </h2>
            <div id="Mdp_modif_div">
                <span id="Text_Modif_mdp">Ancien Mot de Passe</span>
                <input type="text" id="Input_Mdp_modif_div" placeholder="Old Password"></input>
            </div>

            <div id="Mdp_modif_div">
                <span id="Text_Modif_mdp">Nouvau Mot de Passe</span>
                <input type="text" id="Input_Mdp_modif_div" placeholder="New Password"></input>
            </div>

            <div id="Mdp_modif_div">
                <span id="Text_Modif_mdp">Confirmer le Mot de Passe</span>
                <input type="text" id="Input_Mdp_modif_div" placeholder="Confirm Password"></input>
            </div>
            <input type="submit" value="Changer de mot de passe" id="Sauvegarde_modif_mdp"></input>
        </span>
    </div>

    <div id="div2">
        <div style="padding: 2em;">
            <span style="display: flex; flex-direction: row;">
                <span>
                    <img src="../Images/exclamation.svg" style="width: 45px; margin-top: 0.5em;">
                </span>

                <span style="display: flex; flex-direction: column;">
                    <span style="padding: 1em 0 0.5em 1em; font-size: 1.2em; font-weight: 700;">Supprimer votre compte</span>
                    <span style=" padding: 1em; font-weight: 600;">Si vous supprimez votre compte, vous en perdrez l'accès définitif sans possibilité de le récupérer.<br> Vos données personnelles et vos progrès seront effacés et perdus, de même que tout abonnement en cours.</span>
                </span>
            </span>

            <span>
                <button style="width: 30%; background-color: rgba(255,0,0,0.75); border-radius: 1em; color: white; border: none; height: 25%; font-size: 1em; margin: 1em 0 2em 0;">Supprimer le compte</button>
            </span>
        </div>
    </div>
</body>