// createQuizz.php
<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $id_cours = $_POST['id_cours'];
    $path_img_pres = $_POST['path_img_pres'];
    $path_content = $_POST['path_content'];
    $temps_limit = $_POST['temps_limit'];
    $description = $_POST['description'];

    $sql = "INSERT INTO QUIZZ (nom, id_cours, path_img_pres, path_content, temps_limit, description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("sisssi", $nom, $id_cours, $path_img_pres, $path_content, $temps_limit, $description);

    if ($stmt->execute()) {
        echo "Quizz créé avec succès.";
    } else {
        echo "Erreur lors de la création du quizz: " . $stmt->error;
    }

    $stmt->close();
    $dbh->close();
}
?>
