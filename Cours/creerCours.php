<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = isset($_POST['prix']) ? $_POST['prix'] : 0;
    $image = $_FILES['image']['nom'];
    $id_user = $_SESSION['id_user'];

    move_uploaded_file($_FILES['image']['tmp_nom'], "uploads/" . $image);

    $stmt = $db->prepare("INSERT INTO COURS (nom, niveau, prix, path_image_pres, id_user) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $niveau, $prix, $image, $id_user]);

    header("Location: explorerLesCours.php");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un cours</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Créer un cours</h1>
    <form action="creerCours.php" method="post" enctype="multipart/form-data">
        <label for="nom">Nom du cours</label>
        <input type="text" id="nom" nom="nom" required>

        <label for="niveau">Niveau</label>
        <select id="niveau" nom="niveau">
            <option value="Débutant">Débutant</option>
            <option value="Intermédiaire">Intermédiaire</option>
            <option value="Avancé">Avancé</option>
        </select>

        <label for="prix">Prix</label>
        <input type="number" id="prix" nom="prix">

        <label for="image">Image</label>
        <input type="file" id="image" nom="image" required>

        <button type="submit">Créer le cours</button>
    </form>
</body>
</html>
