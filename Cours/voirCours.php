<?php require_once('db.php'); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Voir le Cours</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Additional styling specific to this page */
        .content-container {
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
        }

        .section {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f0f0f0;
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
    </style>
</head>

<body>
    <?php
    include 'header.php';

    session_start(); // Démarrage de la session si ce n'est pas déjà fait

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
        } else {
            $id_user = $_SESSION['id_user'];

            // Insertion dans la table LIKES_COURS
            $sql_like = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (?, ?)";
            $stmt_like = $dbh->prepare($sql_like);
            $stmt_like->execute([$id_user, $id_cours]);

            // Rafraîchir la page pour refléter le nouveau like
            header("Refresh:0");
            exit();
        }
    }
    ?>
</body>

</html>
