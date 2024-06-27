<?php
session_start();
include 'db.php';

$id_cours = $_POST['id_cours'];
$id_user = $_SESSION['user_id']; // Récupère l'ID de l'utilisateur à partir de la session

$sql = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (:id_user, :id_cours)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_user', $id_user);
$stmt->bindParam(':id_cours', $id_cours);

if ($stmt->execute()) {
    echo "Cours ajouté à vos suivis avec succès.";
} else {
    echo "Erreur lors de l'ajout du cours à vos suivis.";
}
?>
