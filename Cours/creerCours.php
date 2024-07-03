<?php
session_start();
if (str_contains($_SESSION['referer'], '?')) {
    $concat = '&';
} else {
    $concat = '?';
}

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';


$id_user = $_SESSION['id_user'];

try {
    // ici on vérification de si l'utilisateur existe dans la table USER
    $stmt = $dbh->prepare("SELECT id_USER FROM USER WHERE id_USER = :id_user");
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        echo "Utilisateur avec ID " . $id_user . " non trouvé dans la base de données USER.";
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $description = $_POST['description'];

    //Ici on verifie si l'image est recevable 
    if ($_FILES["image_pres"]["size"] > 0 && is_uploaded_file($_FILES["image_pres"]["tmp_name"])) {
        $target_dir = "/var/www/html/SchoolPea/Cours/uploads/";
        $target_file = $target_dir . basename($_FILES["image_pres"]["name"]);


        if (move_uploaded_file($_FILES["image_pres"]["tmp_name"], $target_file)) {

            $dbh->beginTransaction();

            try {
                $pathImg = 'https://schoolpea.com/Cours/uploads/' . basename($_FILES["image_pres"]["name"]);
                $sql_insert_cours = "INSERT INTO COURS (nom, niveau, description, id_USER, path_image_pres)
                                    VALUES (:nom, :niveau, :description, :id_user, :path_image_pres)";
                $stmt_insert_cours = $dbh->prepare($sql_insert_cours);
                $stmt_insert_cours->bindValue(':nom', $nom, PDO::PARAM_STR);
                $stmt_insert_cours->bindValue(':niveau', $niveau, PDO::PARAM_STR);
                $stmt_insert_cours->bindValue(':description', $description, PDO::PARAM_STR);
                $stmt_insert_cours->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                $stmt_insert_cours->bindValue(':path_image_pres', $pathImg, PDO::PARAM_STR);
                $stmt_insert_cours->execute();
                $id_cours = $dbh->lastInsertId();

                // Insérer les sections, titres et paragraphes
                if (!empty($_POST['sections']) && is_array($_POST['sections'])) {
                    foreach ($_POST['sections'] as $section) {

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

                                                    $sql_insert_paragraphe = "INSERT INTO PARAGRAPHE (id_titre, contenu)
                                                                            VALUES (:id_titre, :contenu_paragraphe)";
                                                    $stmt_insert_paragraphe = $dbh->prepare($sql_insert_paragraphe);
                                                    $stmt_insert_paragraphe->bindValue(':id_titre', $id_titre, PDO::PARAM_INT);
                                                    $stmt_insert_paragraphe->bindValue(':contenu_paragraphe', $paragraphe, PDO::PARAM_STR);
                                                    $stmt_insert_paragraphe->execute();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $dbh->commit();

                echo "Cours créé avec succès !";
                header('Location: ' . $_SESSION['referer']) . $concat . 'success=2';
            } catch (PDOException $e) {

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

$dbh = null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Cours</title>
    <style>
        .section,
        .titre,
        .paragraphe {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            position: relative;
        }

        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
        }

        .section .titre,
        .titre .paragraphe {
            margin-top: 10px;
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
            <!-- le script sera ici -->
        </div><br>

        <input type="submit" value="Créer le Cours">
    </form>

    <script>
        document.getElementById('ajouter_section').addEventListener('click', function() {
            var sectionsDiv = document.getElementById('sections');
            var nextSectionIndex = sectionsDiv.children.length;

            var newSection = document.createElement('div');
            newSection.className = 'section';

            var removeSectionButton = document.createElement('button');
            removeSectionButton.className = 'remove-btn';
            removeSectionButton.type = 'button';
            removeSectionButton.textContent = 'Supprimer';
            removeSectionButton.onclick = function() {
                sectionsDiv.removeChild(newSection);
            };
            newSection.appendChild(removeSectionButton);

            var sectionTitleInput = document.createElement('input');
            sectionTitleInput.type = 'text';
            sectionTitleInput.name = 'sections[' + nextSectionIndex + '][titre]';
            sectionTitleInput.placeholder = 'Titre de la Section';
            sectionTitleInput.required = true;
            newSection.appendChild(sectionTitleInput);


            var addTitleButton = document.createElement('button');
            addTitleButton.type = 'button';
            addTitleButton.textContent = 'Ajouter un Titre';
            addTitleButton.onclick = function() {
                addTitle(newSection, nextSectionIndex);
            };
            newSection.appendChild(addTitleButton);


            var titlesDiv = document.createElement('div');
            titlesDiv.className = 'titles';
            newSection.appendChild(titlesDiv);

            sectionsDiv.appendChild(newSection);
        });

        function addTitle(sectionDiv, sectionIndex) {
            var titlesDiv = sectionDiv.querySelector('.titles');
            var nextTitleIndex = titlesDiv.children.length;

            var newTitle = document.createElement('div');
            newTitle.className = 'titre';


            var removeTitleButton = document.createElement('button');
            removeTitleButton.className = 'remove-btn';
            removeTitleButton.type = 'button';
            removeTitleButton.textContent = 'Supprimer';
            removeTitleButton.onclick = function() {
                titlesDiv.removeChild(newTitle);
            };
            newTitle.appendChild(removeTitleButton);


            var titleInput = document.createElement('input');
            titleInput.type = 'text';
            titleInput.name = 'sections[' + sectionIndex + '][titres][' + nextTitleIndex + '][titre]';
            titleInput.placeholder = 'Titre';
            titleInput.required = false;
            newTitle.appendChild(titleInput);


            var addParagrapheButton = document.createElement('button');
            addParagrapheButton.type = 'button';
            addParagrapheButton.textContent = 'Ajouter un Paragraphe';
            addParagrapheButton.onclick = function() {
                addParagraphe(newTitle, sectionIndex, nextTitleIndex);
            };
            newTitle.appendChild(addParagrapheButton);


            var paragraphesDiv = document.createElement('div');
            paragraphesDiv.className = 'paragraphes';
            newTitle.appendChild(paragraphesDiv);

            titlesDiv.appendChild(newTitle);
        }

        function addParagraphe(titleDiv, sectionIndex, titleIndex) {
            var paragraphesDiv = titleDiv.querySelector('.paragraphes');
            var nextParagrapheIndex = paragraphesDiv.children.length; // Index du prochain paragraphe à ajouter

            var newParagraphe = document.createElement('div');
            newParagraphe.className = 'paragraphe';


            var removeParagrapheButton = document.createElement('button');
            removeParagrapheButton.className = 'remove-btn';
            removeParagrapheButton.type = 'button';
            removeParagrapheButton.textContent = 'Supprimer';
            removeParagrapheButton.onclick = function() {
                paragraphesDiv.removeChild(newParagraphe);
            };
            newParagraphe.appendChild(removeParagrapheButton);


            var paragrapheTextarea = document.createElement('textarea');
            paragrapheTextarea.name = 'sections[' + sectionIndex + '][titres][' + titleIndex + '][paragraphes][' + nextParagrapheIndex + ']';
            paragrapheTextarea.placeholder = 'Paragraphe';
            paragrapheTextarea.rows = 4;
            paragrapheTextarea.required = false;
            newParagraphe.appendChild(paragrapheTextarea);

            paragraphesDiv.appendChild(newParagraphe);
        }
    </script>
</body>

</html>