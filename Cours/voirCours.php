<?php require_once('db.php'); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Voir le Cours</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
   <style>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap");

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Montserrat", sans-serif;
    transition: background-color 0.3s, color 0.3s;
}

/* Styles communs pour les deux modes */
.content-container {
    margin: 20px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    transition: background-color 0.3s, color 0.3s;
}

.section {
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 10px;
    transition: background-color 0.3s, color 0.3s;
}

.section-title {
    font-size: 20px;
    margin-bottom: 10px;
}

.title {
    font-size: 18px;
    margin-bottom: 5px;
}

.paragraph {
    margin-bottom: 15px;
    line-height: 1.6;
}

#Cours_Content {
    padding: 5em;
    margin: 5em;
}

/* Mode clair */
body[data-theme='light'] {
    background-color: #f0f0f0;
    color: #333;
}

body[data-theme='light'] .content-container {
    background-color: #fff;
}

body[data-theme='light'] .section {
    background-color: #f0f0f0;
}

/* Mode sombre */
body[data-theme='dark'] {
    background-color: #1a1a1a;
    color: #fff;
}

body[data-theme='dark'] .content-container {
    background-color: #333;
}

body[data-theme='dark'] .section {
    background-color: #444;
}
</style>

</head>

<body>
    <span class="trait"></span>
    <div id="Cours_Content">
        <?php
        session_start(); // Démarrage de la session

        // Vérification de la session et inclusion de l'en-tête
        if (isset($_SESSION['mail_valide'])) {
            include($_SERVER['DOCUMENT_ROOT'] . '/headerL.php');
        } else {
            header('Location: https://schoolpea.com/Connexion');
            exit();
        }

        // Vérification de l'ID du cours dans l'URL
        if (!isset($_GET['id_cours'])) {
            echo "Erreur: ID de cours non spécifié.";
            exit();
        }

        $id_cours = $_GET['id_cours'];

        // Récupérer les détails du cours
        $sql = "SELECT * FROM COURS WHERE id_COURS = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$id_cours]);

        if ($stmt->rowCount() > 0) {
            $cours = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>

            <div class="content-container">
                <h2><?php echo htmlspecialchars($cours['nom']); ?></h2>
                <p>Niveau : <?php echo htmlspecialchars($cours['niveau']); ?></p>
                <div class="cours-description"><?php echo htmlspecialchars($cours['description']); ?></div>

                <!-- Formulaire pour liker le cours -->
                <form action="voirCours.php?id_cours=<?php echo htmlspecialchars($id_cours); ?>" method="POST">
                    <input type="hidden" name="action" value="like">
                    <button type="submit" class="button">Liker ce cours</button>
                </form>

                <!-- Bouton pour générer le PDF du cours -->
                <a href="downloadPdf.php?id_cours=<?php echo $id_cours; ?>" class="button">Télécharger le PDF</a>

                <!-- Récupérer les sections liées au cours -->
                <?php
                $sql_section = "SELECT * FROM SECTIONS WHERE id_cours = ?";
                $stmt_section = $dbh->prepare($sql_section);
                $stmt_section->execute([$id_cours]);

                while ($section = $stmt_section->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="section">';
                    echo '<h3 class="section-title">' . htmlspecialchars($section['titre']) . '</h3>';

                    // Récupérer les titres liés à la section
                    $id_section = $section['id_section'];
                    $sql_titre = "SELECT * FROM TITRE WHERE id_section = ?";
                    $stmt_titre = $dbh->prepare($sql_titre);
                    $stmt_titre->execute([$id_section]);

                    while ($titre = $stmt_titre->fetch(PDO::FETCH_ASSOC)) {
                        echo '<h4 class="title">' . htmlspecialchars($titre['titre']) . '</h4>';

                        // Récupérer les paragraphes liés au titre
                        $id_titre = $titre['id_titre'];
                        $sql_paragraphe = "SELECT * FROM PARAGRAPHE WHERE id_titre = ?";
                        $stmt_paragraphe = $dbh->prepare($sql_paragraphe);
                        $stmt_paragraphe->execute([$id_titre]);

                        while ($paragraphe = $stmt_paragraphe->fetch(PDO::FETCH_ASSOC)) {
                            echo '<p class="paragraph">' . htmlspecialchars($paragraphe['contenu']) . '</p>';
                        }
                    }

                    echo '</div>'; // Fermeture de la section
                }
                ?>
            </div>
        <?php
        } else {
            echo "Cours non trouvé.";
        }

        // Traitement de l'action de like
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'like') {
            if (!isset($_SESSION['id_user'])) {
                echo "Vous devez être connecté pour aimer un cours.";
                exit(); // Arrêt de l'exécution si l'utilisateur n'est pas connecté
            } else {
                $id_user = $_SESSION['id_user'];

                // Insertion dans la table LIKES_COURS
                $sql_like = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (?, ?)";
                $stmt_like = $dbh->prepare($sql_like);
                $stmt_like->execute([$id_user, $id_cours]);

                // Redirection vers la page de cours après avoir aimé
                header("Location: voirCours.php?id_cours=$id_cours");
                exit();
            }
        }
        ?>
    </div>
</body>

</html>