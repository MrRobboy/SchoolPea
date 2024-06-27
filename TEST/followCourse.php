<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php"); // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

$id_cours = $_POST['id_cours'];
$id_user = $_SESSION['id_user'];

// Vérifier si le cours est déjà suivi
$sql_check = "SELECT * FROM LIKES_COURS WHERE id_user = :id_user AND id_cours = :id_cours";
$stmt_check = $dbh->prepare($sql_check);
$stmt_check->bindParam(':id_user', $id_user);
$stmt_check->bindParam(':id_cours', $id_cours);
$stmt_check->execute();

if ($stmt_check->rowCount() == 0) {
    // Insérer dans LIKES_COURS
    $sql = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (:id_user, :id_cours)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_cours', $id_cours);
    $stmt->execute();

    echo "Cours suivi avec succès.";
} else {
    echo "Vous suivez déjà ce cours.";
}
?>
