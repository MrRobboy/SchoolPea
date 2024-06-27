<?php
session_start();

// Vérification de l'existence de la session utilisateur
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php"); // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

include 'db.php'; // Inclusion du fichier de connexion à la base de données

// Récupération de l'ID utilisateur depuis la session
$id_user = $_SESSION['id_user'];

try {
    // Vérification si l'utilisateur existe dans la table USER
    $stmt = $dbh->prepare("SELECT id_USER FROM USER WHERE id_USER = :id_user");
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        echo "Utilisateur avec ID " . $id_user . " non trouvé dans la base de données USER.";
        exit(); // Arrêt de l'exécution si l'utilisateur n'existe pas
    }
} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage();
    // En pratique, vous devriez logger cette erreur plutôt que de l'afficher directement
}

// Traitement du formulaire de création de cours
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $description = $_POST['description'];

    // Vérification et traitement de l'image de présentation
    if ($_FILES["image_pres"]["size"] > 0 && is_uploaded_file($_FILES["image_pres"]["tmp_name"])) {
        $target_dir = "/var/www/html/SchoolPea/Cours/uploads/";
        $target_file = $target_dir . basename($_FILES["image_pres"]["name"]);

        if (move_uploaded_file($_FILES["image_pres"]["tmp_name"], $target_file)) {
            // Début de la transaction
            $dbh->beginTransaction();

            try {
                // Insérer les informations générales du cours dans la table COURS
                $sql_insert_cours = "INSERT INTO COURS (nom, niveau, description, id_USER, path_image_pres)
                                    VALUES (:nom, :niveau, :description, :id_user, :path_image_pres)";
                $stmt_insert_cours = $dbh->prepare($sql_insert_cours);
                $stmt_insert_cours->bindValue(':nom', $nom, PDO::PARAM_STR);
                $stmt_insert_cours->bindValue(':niveau', $niveau, PDO::PARAM_STR);
                $stmt_insert_cours->bindValue(':description', $description, PDO::PARAM_STR);
                $stmt_insert_cours->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                $stmt_insert_cours->bindValue(':path_image_pres', $target_file, PDO::PARAM_STR);
                $stmt_insert_cours->execute();
                $id_cours = $dbh->lastInsertId();

                // Insérer les sections, titres et paragraphes
                if (!empty($_POST['sections']) && is_array($_POST['sections'])) {
                    foreach ($_POST['sections'] as $section) {
                        // Insertion de la section dans SECTIONS
                        if (isset($section['titre']) && !empty($section['titre'])) {
                            $sql_insert_section = "INSERT INTO SECTIONS (id_cours, titre)
                                                VALUES (:id_cours, :titre_section)";
                            $stmt_insert_section = $dbh->prepare($sql_insert_section);
                            $stmt_insert_section->bindValue(':id_cours', $id_cours, PDO::PARAM_INT);
                            $stmt_insert_section->bindValue(':titre_section', $section['titre'], PDO::PARAM_STR);
                            $stmt_insert_section->execute();
                            $id_section = $dbh->lastInsertId();

                            if (isset($section['titres']) && is_array($section['titres'])) {
                                foreach ($section['titres'] as $titre) {
                                    if (isset($titre['titre']) && !empty($titre['titre'])) {
                                        // Insérer le titre dans TITRE
                                        $sql_insert_titre = "INSERT INTO TITRE (id_section, titre)
                                                            VALUES (:id_section, :titre_titre)";
                                        $stmt_insert_titre = $dbh->prepare($sql_insert_titre);
                                        $stmt_insert_titre->bindValue(':id_section', $id_section, PDO::PARAM_INT);
                                        $stmt_insert_titre->bindValue(':titre_titre', $titre['titre'], PDO::PARAM_STR);
                                        $stmt_insert_titre->execute();
                                        $id_titre = $dbh->lastInsertId();

                                        // Pour chaque paragraphe sous le titre
                                        if (isset($titre['paragraphes']) && is_array($titre['paragraphes'])) {
                                            foreach ($titre['paragraphes'] as $paragraphe) {
                                                if (!empty($paragraphe)) {
                                                    // Insertion du paragraphe dans PARAGRAPHE
                                                    $sql_insert_paragraphe = "INSERT INTO PARAGRAPHE (id_titre, contenu)
                                                                            VALUES (:id_titre, :contenu_paragraphe)";
                                                    $stmt_insert_paragraphe = $dbh->prepare($sql_insert_paragraphe);
                                                    $stmt_insert_paragraphe->bindValue(':id_titre', $id_titre, PDO::PARAM_INT);
                                                    $stmt_insert_paragraphe->bindValue(':contenu_paragraphe', $paragraphe, PDO::PARAM_STR);
                                                    $stmt_insert_paragraphe->execute();
                                                } else {
                                                    echo "Paragraphe vide trouvé, pas d'insertion pour ce paragraphe.<br>";
                                                }
                                            }
                                        } else {
                                            echo "Aucun paragraphe trouvé pour le titre: " . $titre['titre'] . "<br>";
                                        }
                                    } else {
                                        echo "Titre vide ou non défini trouvé dans une section.<br>";
                                    }
                                }
                            } else {
                                echo "Aucun titre trouvé pour la section: " . $section['titre'] . "<br>";
                            }
                        } else {
                            echo "Titre de section vide ou non défini trouvé.<br>";
                        }
                    }
                } else {
                    echo "Aucune section trouvée dans les données POST.<br>";
                }

                // Valider la transaction
                $dbh->commit();

                echo "Cours créé avec succès !";

            } catch (PDOException $e) {
                // En cas d'erreur, annuler la transaction
                $dbh->rollBack();
                echo "Erreur lors de l'insertion : " . $e->getMessage();
            }
        } else {
            echo "Échec du téléchargement de l'image de présentation.<br>";
        }
    } else {
        echo "Aucune image de présentation trouvée ou image invalide.<br>";
    }
}

$dbh = null; // Fermeture de la connexion PDO
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Cours</title>
    <style>
        .section {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .titres {
            margin-top: 10px;
            border: 1px solid #eee;
            padding: 5px;
        }
        .paragraphes {
            margin-top: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h2>Création de Cours</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <label for="nom">Nom du Cours :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="niveau">Niveau :</label>
        <select id="niveau" name="niveau">
            <option value="debutant">Débutant</option>
            <option value="intermediaire">Intermédiaire</option>
            <option value="avance">Avancé</option>
        </select><br><br>

        <label for="image_pres">Image de Présentation :</label>
        <input type="file" id="image_pres" name="image_pres" accept="image/*"><br><br>

        <label for="description">Description :</label><br>
        <textarea id="description" name="description" rows="4"></textarea><br><br>

        <h3>Sections</h3>
        <button type="button" id="ajouter_section">Ajouter une Section</button><br><br>

        <div id="sections">
            <!-- Contenu des sections ajouté dynamiquement ici -->
        </div><br>

        <input type="submit" value="Créer le Cours">
    </form>

    <script>
        document.getElementById('ajouter_section').addEventListener('click', function() {
            var sectionsDiv = document.getElementById('sections');
            var nextSectionIndex = sectionsDiv.children.length; // Index de la prochaine section à ajouter

            var newSection = document.createElement('div');
            newSection.className = 'section';

            // Création du champ de titre de la section
            var titreSectionLabel = document.createElement('label');
            titreSectionLabel.textContent = 'Titre de la section :';
            var titreSectionInput = document.createElement('input');
            titreSectionInput.type = 'text';
            titreSectionInput.name = 'sections[' + nextSectionIndex + '][titre]';
            titreSectionInput.required = true;

            newSection.appendChild(titreSectionLabel);
            newSection.appendChild(titreSectionInput);

            // Ajout du bouton pour ajouter un titre à la section
            var ajouterTitreBtn = document.createElement('button');
            ajouterTitreBtn.textContent = 'Ajouter un titre';
            ajouterTitreBtn.type = 'button';
            ajouterTitreBtn.className = 'ajouter_titre';
            newSection.appendChild(ajouterTitreBtn);

            // Écouteur d'événement pour ajouter un titre à cette section
            ajouterTitreBtn.addEventListener('click', function() {
                var titresDiv = document.createElement('div');
                titresDiv.className = 'titres';

                // Création du champ de titre
                var titreLabel = document.createElement('label');
                titreLabel.textContent = 'Titre :';
                var titreInput = document.createElement('input');
                titreInput.type = 'text';
                titreInput.name = 'sections[' + nextSectionIndex + '][titres][' + newSection.getElementsByClassName('titres').length + '][titre]';
                titreInput.required = true;

                // Ajout du champ de titre à la section
                titresDiv.appendChild(titreLabel);
                titresDiv.appendChild(titreInput);

                // Ajout du bouton pour ajouter un paragraphe à ce titre
                var ajouterParagrapheBtn = document.createElement('button');
                ajouterParagrapheBtn.textContent = 'Ajouter un paragraphe';
                ajouterParagrapheBtn.type = 'button';
                ajouterParagrapheBtn.className = 'ajouter_paragraphe';
                titresDiv.appendChild(ajouterParagrapheBtn);

                // Écouteur d'événement pour ajouter un paragraphe à ce titre
                ajouterParagrapheBtn.addEventListener('click', function() {
                    var paragraphesDiv = document.createElement('div');
                    paragraphesDiv.className = 'paragraphes';

                    // Création du champ de paragraphe
                    var paragrapheLabel = document.createElement('label');
                    paragrapheLabel.textContent = 'Paragraphe :';
                    var paragrapheTextarea = document.createElement('textarea');
                    paragrapheTextarea.name = 'sections[' + nextSectionIndex + '][titres][' + newSection.getElementsByClassName('titres').length + '][paragraphes][]';
                    paragrapheTextarea.required = true;

                    // Ajout du champ de paragraphe au titre
                    paragraphesDiv.appendChild(paragrapheLabel);
                    paragraphesDiv.appendChild(paragrapheTextarea);

                    titresDiv.appendChild(paragraphesDiv);
                });

                newSection.appendChild(titresDiv);
            });

            sectionsDiv.appendChild(newSection);
        });
    </script>
</body>
</html>
