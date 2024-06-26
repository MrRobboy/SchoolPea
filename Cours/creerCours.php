<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = $_POST['prix'];
    $id_user = 1; // Exemple : récupérer l'ID utilisateur connecté

    $upload_dir = 'images/';
    $upload_file = $upload_dir . basename($_FILES['image_pres']['name']);

    if (move_uploaded_file($_FILES['image_pres']['tmp_name'], $upload_file)) {
        $path_image_pres = $upload_file;

        // Insertion dans la table COURS
        $sql = "INSERT INTO COURS (nom, niveau, prix, id_user, path_image_pres) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdis", $nom, $niveau, $prix, $id_user, $path_image_pres);

        if ($stmt->execute()) {
            $id_cours = $stmt->insert_id;

            // Insertion des sections
            foreach ($_POST['section'] as $section) {
                $titre_section = $section['titre'];

                // Insertion dans la table SECTIONS
                $sql_section = "INSERT INTO SECTIONS (id_cours, titre) VALUES (?, ?)";
                $stmt_section = $conn->prepare($sql_section);
                $stmt_section->bind_param("is", $id_cours, $titre_section);

                if ($stmt_section->execute()) {
                    $id_section = $stmt_section->insert_id;

                    // Insertion des titres
                    foreach ($section['titre'] as $titre) {
                        $titre_titre = $titre['titre'];

                        // Insertion dans la table TITRE
                        $sql_titre = "INSERT INTO TITRE (id_section, titre) VALUES (?, ?)";
                        $stmt_titre = $conn->prepare($sql_titre);
                        $stmt_titre->bind_param("is", $id_section, $titre_titre);

                        if ($stmt_titre->execute()) {
                            $id_titre = $stmt_titre->insert_id;

                            // Insertion des paragraphes
                            foreach ($titre['paragraphe'] as $paragraphe) {
                                // Insertion dans la table PARAGRAPHE
                                $sql_paragraphe = "INSERT INTO PARAGRAPHE (id_titre, contenu) VALUES (?, ?)";
                                $stmt_paragraphe = $conn->prepare($sql_paragraphe);
                                $stmt_paragraphe->bind_param("is", $id_titre, $paragraphe);

                                $stmt_paragraphe->execute();
                            }
                        }
                    }
                }
            }

            echo "Cours créé avec succès.";
        } else {
            echo "Erreur : " . $conn->error;
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}
?>

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
    
    <div id="sections">
        <h3>Sections</h3>
        <div class="section">
            <label for="titre_section">Titre de la section :</label>
            <input type="text" name="section[0][titre]" required><br>
            
            <div class="titres">
                <h4>Titres</h4>
                <div class="titre">
                    <label for="titre">Titre :</label>
                    <input type="text" name="section[0][titre][0][titre]" required><br>
                    
                    <div class="paragraphes">
                        <h5>Paragraphes</h5>
                        <label for="paragraphe">Paragraphe :</label>
                        <textarea name="section[0][titre][0][paragraphe][]" required></textarea><br>
                    </div>
                    <button type="button" class="ajouter_paragraphe">Ajouter un paragraphe</button>
                </div>
                <button type="button" class="ajouter_titre">Ajouter un titre</button>
            </div>
        </div>
        <button type="button" id="ajouter_section">Ajouter une section</button>
    </div>
    
    <button type="submit">Créer le cours</button>
</form>

<?php include 'footer.php'; ?>
