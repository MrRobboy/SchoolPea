<?php
session_start(); // Démarrer la session en haut de votre fichier

// Vérifier si l'utilisateur est connecté ou rediriger vers la page de connexion si nécessaire
if (!isset($_SESSION['id_user'])) {
    // Redirection vers la page de connexion
    header("Location: login.php");
    exit();
}

include 'db.php'; // Inclure votre fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données principales du cours
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $description = $_POST['description'];
    $id_user = $_SESSION['id_user']; // Récupération de l'ID utilisateur depuis la session

    // Traitement de l'image de présentation
    if ($_FILES["image_pres"]["size"] > 0 && is_uploaded_file($_FILES["image_pres"]["tmp_name"])) {
        $target_dir = "/var/www/html/SchoolPea/Cours/uploads/";
        $target_file = $target_dir . basename($_FILES["image_pres"]["name"]);

        // Vérification si le fichier est une vraie image
        $check = getimagesize($_FILES["image_pres"]["tmp_name"]);
        if ($check === false) {
            echo "Le fichier n'est pas une image valide.";
        } else {
            // Déplacer le fichier téléchargé vers le répertoire cible
            if (move_uploaded_file($_FILES["image_pres"]["tmp_name"], $target_file)) {
                echo "Le fichier " . htmlspecialchars(basename($_FILES["image_pres"]["name"])) . " a été téléchargé avec succès.";

                // Insertion des données principales du cours dans la table COURS
                $sql = "INSERT INTO COURS (nom, niveau, id_USER, path_image_pres, description)
                        VALUES (:nom, :niveau, :id_user, :target_file, :description)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindValue(':niveau', $niveau, PDO::PARAM_STR);
                $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                $stmt->bindValue(':target_file', $target_file, PDO::PARAM_STR);
                $stmt->bindValue(':description', $description, PDO::PARAM_STR);
                $stmt->execute();
                $cours_id = $conn->lastInsertId(); // Récupération de l'ID du cours inséré

                // Traitement des sections, titres et paragraphes
                if (isset($_POST['section']) && is_array($_POST['section'])) {
                    foreach ($_POST['section'] as $section) {
                        $titre_section = $section['titre'];

                        // Insertion de la section dans la table SECTIONS
                        $sql = "INSERT INTO SECTIONS (id_COURS, titre)
                                VALUES (:cours_id, :titre_section)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(':cours_id', $cours_id, PDO::PARAM_INT);
                        $stmt->bindValue(':titre_section', $titre_section, PDO::PARAM_STR);
                        $stmt->execute();
                        $section_id = $conn->lastInsertId(); // Récupération de l'ID de la section insérée

                        if (isset($section['titre']) && is_array($section['titre'])) {
                            foreach ($section['titre'] as $titre) {
                                $titre_titre = $titre['titre'];

                                // Insertion du titre dans la table TITRE
                                $sql = "INSERT INTO TITRE (id_SECTION, titre)
                                        VALUES (:section_id, :titre_titre)";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindValue(':section_id', $section_id, PDO::PARAM_INT);
                                $stmt->bindValue(':titre_titre', $titre_titre, PDO::PARAM_STR);
                                $stmt->execute();
                                $titre_id = $conn->lastInsertId(); // Récupération de l'ID du titre inséré

                                if (isset($titre['paragraphe']) && is_array($titre['paragraphe'])) {
                                    foreach ($titre['paragraphe'] as $paragraphe) {
                                        $contenu_paragraphe = $paragraphe;

                                        // Insertion du paragraphe dans la table PARAGRAPHE
                                        $sql = "INSERT INTO PARAGRAPHE (id_TITRE, contenu)
                                                VALUES (:titre_id, :contenu_paragraphe)";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindValue(':titre_id', $titre_id, PDO::PARAM_INT);
                                        $stmt->bindValue(':contenu_paragraphe', $contenu_paragraphe, PDO::PARAM_STR);
                                        $stmt->execute();
                                    }
                                }
                            }
                        }
                    }
                }

                echo "Le cours a été créé avec succès.";

            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }
    } else {
        echo "Veuillez sélectionner une image de présentation.";
    }

    $conn = null; // Fermer la connexion PDO
}
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

        <!-- Champ ID de l'utilisateur auto-complété depuis la session -->
        <label for="id_user">ID de l'Utilisateur :</label>
        <input type="text" id="id_user" name="id_user" value="<?php echo htmlspecialchars($_SESSION['id_user']); ?>" readonly><br><br>

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
            titreSectionInput.name = 'section[' + nextSectionIndex + '][titre]';
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
                titreInput.name = 'section[' + nextSectionIndex + '][titres][' + newSection.getElementsByClassName('titres').length + '][titre]';
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
                    paragrapheTextarea.name = 'section[' + nextSectionIndex + '][titres][' + newSection.getElementsByClassName('titres').length + '][paragraphes][]';
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
