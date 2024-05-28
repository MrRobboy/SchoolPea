<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Schoolpéa</title>
    <link rel="stylesheet" type="text/css" href="./accueil_nl.css" />
</head>

<body>

    <header>
        <span id="accueil">
            <a href="#SchoolPea">
                <img id="logo_header" src="../../public/images/SchoolPea.png" alt="Logo" />
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
                <a href="./connexion.php" class="lien_header">
                    Se Connecter
                </a>
            </span>

            <span>
                <a href="./inscription.php" class="lien_header">
                    S'inscrire
                </a>
            </span>
        </span>
    </header>

    <span class="trait" id="SchoolPea"></span>

    <div id="shadow_search">
        <div id="Search_section">
            <div class="aff">
                <span id="text_search">
                    <h1 style="font-weight: bold; font-size: 60px">
                        SchoolPéa
                    </h1>
                    <h6 style="font-weight: 500; font-size: 18px">
                        Jouons pour apprendre,<br />
                        Gagnons pour réussir !
                    </h6>
                </span>
                <img id="logo_aff" src="../../public/images/SchoolPea.png" alt="Logo" />
            </div>

            <div class="but">
                <a href="./connexion.php">
                    Trouver un cours
                </a>
                <a href="./connexion.php">
                    Trouver un quizz
                </a>
            </div>

            <div class="rec">api fetch à setup</div>
        </div>
    </div>

    <span class="trait" id="Explorer_les_cours"></span>

    <div id="Cours_section">
        <span>
            <p id="titre_cours">Une large sélection de Cours</p>
        </span>
        <div id="div_cours">
            <div class="fenetre">
                <span id="fen1">Cours_1</span>
                <span id="fen2">Cours_2</span>
                <span id="fen3">Cours_3</span>
                <span id="fen4">Cours_4</span>
            </div>

            <div class="fenetre">
                <span id="fen5">Cours_5</span>
                <span id="fen6">Cours_6</span>
                <span id="fen7">Cours_7</span>
                <span id="fen8">Cours_8</span>
            </div>
        </div>
        <span>
            <a class="voir_plus" href="./connexion.php">
                Voir plus >
            </a>
        </span>
    </div>

    <span class="trait" id="2"></span>

    <div id="Quizz_section">
        <span>
            <p id="titre_quizz">Autant de Cours que de Quizzs !</p>
        </span>
        <div id="div_quizz">
            <div class="fenetre">
                <span id="quizz_1"> Quizz_1 </span>
                <span id="quizz_2"> Quizz_2 </span>
                <span id="quizz_3"> Quizz_3 </span>
                <span id="quizz_4"> Quizz_4 </span>
            </div>

            <div class="fenetre">
                <span id="quizz_5"> Quizz_5 </span>
                <span id="quizz_6"> Quizz_6 </span>
                <span id="quizz_7"> Quizz_7 </span>
                <span id="quizz_8"> Quizz_8 </span>
            </div>
        </div>

        <span>
            <a class="voir_plus" href="./connexion.php">
                Voir plus >
            </a>
        </span>
    </div>

    <span class="trait" id="3"></span>

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