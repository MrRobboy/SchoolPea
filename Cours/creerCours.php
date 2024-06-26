<?php
// Inclusion du fichier de connexion à la base de données et du fichier d'en-tête
include 'db.php';
include 'header.php';

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = $_POST['prix'];
    $id_user = 1; // Exemple : récupérer l'ID utilisateur connecté

    // Dossier d'upload pour les images
    $upload_dir = 'images/';
    $upload_file = $upload_dir . basename($_FILES['image_pres']['name']);

    // Vérification et déplacement du fichier uploadé
    if (move_uploaded_file($_FILES['image_pres']['tmp_name'], $upload_file)) {
        $path_image_pres = $upload_file;

        try {
            // Configuration de PDO pour afficher les erreurs
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Début de la transaction
            $conn->beginTransaction();

            // Insertion dans la table COURS
            $sql_cours = "INSERT INTO COURS (nom, niveau, prix, id_user, path_image_pres)
                          VALUES (:nom, :niveau, :prix, :id_user, :path_image_pres)";
            $stmt_cours = $conn->prepare($sql_cours);
            $stmt_cours->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt_cours->bindParam(':niveau', $niveau, PDO::PARAM_STR);
            $stmt_cours->bindParam(':prix', $prix, PDO::PARAM_INT);
            $stmt_cours->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt_cours->bindParam(':path_image_pres', $path_image_pres, PDO::PARAM_STR);
            $stmt_cours->execute();

            // Récupération de l'ID du cours inséré
            $id_cours = $conn->lastInsertId();

            // Insertion dans la table SECTIONS (exemple avec une section)
            $sections = $_POST['section']; // Supposons que $_POST['section'] est un tableau de sections
            foreach ($sections as $section) {
                $titre_section = $section['titre'];

                $sql_section = "INSERT INTO SECTIONS (id_cours, titre) VALUES (:id_cours, :titre_section)";
                $stmt_section = $conn->prepare($sql_section);
                $stmt_section->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
                $stmt_section->bindParam(':titre_section', $titre_section, PDO::PARAM_STR);
                $stmt_section->execute();

                // Récupération de l'ID de la section insérée
                $id_section = $conn->lastInsertId();

                // Insertion dans la table TITRE (exemple avec des titres dans une section)
                $titres = $section['titres']; // Supposons que $_POST['section']['titres'] est un tableau de titres
                foreach ($titres as $titre) {
                    $titre_titre = $titre['titre'];

                    $sql_titre = "INSERT INTO TITRE (id_section, titre) VALUES (:id_section, :titre_titre)";
                    $stmt_titre = $conn->prepare($sql_titre);
                    $stmt_titre->bindParam(':id_section', $id_section, PDO::PARAM_INT);
                    $stmt_titre->bindParam(':titre_titre', $titre_titre, PDO::PARAM_STR);
                    $stmt_titre->execute();

                    // Récupération de l'ID du titre inséré
                    $id_titre = $conn->lastInsertId();

                    // Insertion dans la table PARAGRAPHE (exemple avec des paragraphes dans un titre)
                    $paragraphes = $titre['paragraphes']; // Supposons que $_POST['section']['titres']['paragraphes'] est un tableau de paragraphes
                    foreach ($paragraphes as $paragraphe) {
                        $contenu_paragraphe = $paragraphe;

                        $sql_paragraphe = "INSERT INTO PARAGRAPHE (id_titre, contenu) VALUES (:id_titre, :contenu_paragraphe)";
                        $stmt_paragraphe = $conn->prepare($sql_paragraphe);
                        $stmt_paragraphe->bindParam(':id_titre', $id_titre, PDO::PARAM_INT);
                        $stmt_paragraphe->bindParam(':contenu_paragraphe', $contenu_paragraphe, PDO::PARAM_STR);
                        $stmt_paragraphe->execute();
                    }
                }
            }

            // Validation de la transaction
            $conn->commit();

            echo "Cours créé avec succès.";
        } catch(PDOException $e) {
            // Annulation de la transaction en cas d'erreur
            $conn->rollback();
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}
?>

<!-- Formulaire HTML pour créer un nouveau cours -->
<h2>Créer un nouveau cours</h2>
<form action="creerCours.php" method="post" enctype="multipart/form-data">
    <label for="nom">Nom du cours :</label>
    <input type="text" name="nom" id="nom" required><br>
    
    <label for="niveau">Niveau :</label>
    <input type="text" name="niveau" id="niveau" required><br>
    
    <label for="prix">Prix :</label>
    <input type="number" name="prix" id="prix" required><br>
    
    <label for="image_pres">Image de présentation :</label>
    <input type="file" name="image_pres" id="image_pres" accept="image/*" required><br>
    
    <!-- Ajoutez ici les champs pour les sections, titres, paragraphes, etc. selon votre structure -->

    <button type="submit">Créer le cours</button>
</form>

<?php include 'footer.php'; ?>
