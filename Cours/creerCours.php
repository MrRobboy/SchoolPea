<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = $_POST['prix'];
    $id_USER = 1; // Exemple : récupérer l'ID utilisateur connecté

    $upload_dir = 'images/';
    
    // Créer le répertoire s'il n'existe pas
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $upload_file = $upload_dir . basename($_FILES['image_pres']['name']);

    if (move_uploaded_file($_FILES['image_pres']['tmp_name'], $upload_file)) {
        $path_image_pres = $upload_file;

        // Utilisation de PDO pour sécuriser les requêtes
        $sql = "INSERT INTO COURS (nom, niveau, prix, id_USER, path_image_pres) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $niveau, $prix, $id_USER, $path_image_pres]);

        $id_COURS = $conn->lastInsertId();

        for ($i = 0; $i < count($_POST['section']); $i++) {
            $titre_section = $_POST['section'][$i]['titre'];
            $sql_section = "INSERT INTO SECTION (id_COURS, titre) VALUES (?, ?)";
            $stmt_section = $conn->prepare($sql_section);
            $stmt_section->execute([$id_COURS, $titre_section]);

            $id_section = $conn->lastInsertId();

            for ($j = 0; $j < count($_POST['section'][$i]['titre']); $j++) {
                $titre = $_POST['section'][$i]['titre'][$j]['titre'];
                $sql_titre = "INSERT INTO TITRE (id_section, titre) VALUES (?, ?)";
                $stmt_titre = $conn->prepare($sql_titre);
                $stmt_titre->execute([$id_section, $titre]);

                $id_titre = $conn->lastInsertId();

                for ($k = 0; $k < count($_POST['section'][$i]['titre'][$j]['paragraphe']); $k++) {
                    $paragraphe = $_POST['section'][$i]['titre'][$j]['paragraphe'][$k];
                    $sql_paragraphe = "INSERT INTO PARAGRAPHE (id_titre, contenu) VALUES (?, ?)";
                    $stmt_paragraphe = $conn->prepare($sql_paragraphe);
                    $stmt_paragraphe->execute([$id_titre, $paragraphe]);
                }
            }
        }
        echo "Cours créé avec succès.";
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
