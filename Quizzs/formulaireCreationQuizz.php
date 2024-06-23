<?php
require_once('db.php');

// Traitement du formulaire de création de quizz
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $id_cours = $_POST['id_cours'];
    $path_img_pres = $_POST['path_img_pres'];
    $path_content = $_POST['path_content'];
    $temps_limit = $_POST['temps_limit'];

    $stmt = $dbh->prepare("INSERT INTO QUIZZ (nom, id_cours, path_img_pres, path_content, temps_limit) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $id_cours, $path_img_pres, $path_content, $temps_limit]);

    // Redirection vers la page d'accueil après création du quizz
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Quizz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Créer un Quizz</h1>
    </header>
    <main>
        <form action="" method="post">
            <label>Nom du Quizz</label>
            <input type="text" name="nom" required>
            
            <label>ID du Cours</label>
            <input type="number" name="id_cours" required>

            <label>Chemin de l'Image de Présentation</label>
            <input type="text" name="path_img_pres" required>

            <label>Chemin du Contenu</label>
            <input type="text" name="path_content" required>

            <label>Temps Limite (en minutes)</label>
            <input type="number" name="temps_limit" required>

            <button type="submit">Créer Quizz</button>
        </form>
    </main>
</body>
</html>
