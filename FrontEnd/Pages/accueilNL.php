<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Schoolpéa</title>
    <link rel="stylesheet" type="text/css" href="../Styles/accueilNL.css" />
</head>

<body>

    <header>
        <span id="accueil">
            <a href="#SchoolPea">
                <img id="logo_header" src="../Images/Schoolpea.png" alt="Logo" />
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
                <img id="logo_aff" src="../Images/Schoolpea.png" alt="Logo" />
            </div>

            <div class="but">
                <a href="./connexion.php">
                    Trouver un cours
                </a>
                <a href="./connexion.php">
                    Trouver un quizz
                </a>
            </div>

            <div class="barreDeRecherche">
            <input type="text" id="coursenquizz-search" placeholder="Rechercher un cours ou un quizz ...">
            <button onclick="chercheCoursEtQuizz()">Rechercher</button>
                </div>
        </div>
    </div>

    <span class="trait" id="Explorer_les_cours"></span>

    <div id="Cours_section">
        <span>
            <p id="titre_cours">Une large sélection de Cours</p>
        </span>
        <div class="fenetre">
        <?php
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $bdd = new PDO("mysql:host=localhost;dbname=PA", "root", "root", $options);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Récupération des cours depuis la base de données
            $sql = "SELECT * FROM cours";
            $stmt = $bdd->query($sql);

            $counter = 0;
            while ($row = $stmt->fetch()) {
                if ($counter % 4 == 0 && $counter != 0) {
                    echo "</div><div class='fenetre'>";
                }
                echo "<span id='fen" . ($counter + 1) . "'>" . $row["nom"] . "</span>";
                $counter++;
            }
            
            if ($counter == 0) {
                echo "<span>Aucun cours trouvé.</span>";
            }

        } catch (PDOException $e) {
            echo "Erreur Connexion : " . $e->getMessage();
            die;
        }
        ?>
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
                <?php
                $options = [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];

                try {
                    $bdd = new PDO("mysql:host=localhost;dbname=PA", "root", "root", $options);
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Récupération des quizz depuis la base de données
                    $sql = "SELECT * FROM quizz";
                    $stmt = $bdd->query($sql);

                    $counter = 0;
                    while ($row = $stmt->fetch()) {
                        if ($counter % 4 == 0 && $counter != 0) {
                            echo "</div><div class='fenetre'>";
                        }
                        echo "<span id='quizz_" . ($counter + 1) . "'>" . $row["nom"] . "</span>";
                        $counter++;
                    }
                    
                    if ($counter == 0) {
                        echo "<span>Aucun quizz trouvé.</span>";
                    }

                } catch (PDOException $e) {
                    echo "Erreur Connexion : " . $e->getMessage();
                    die;
                }
                ?>
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
            </span>

            <span class="col4">
                <h4>Newsletter</h4>
                <a>Api fetch à Implémenter <br />Input email</a>
            </span>
        </div>
    </footer>

</body>

</html>