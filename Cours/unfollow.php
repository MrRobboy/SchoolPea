<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour ne plus suivre un cours.";
    exit();
}

$id_cours = $_POST['id_cours'];
$id_user = $_SESSION['user_id'];

// Supprimer le cours de la table LIKES_COURS
$sql = "DELETE FROM LIKES_COURS WHERE id_user = :id_user AND id_cours = :id_cours";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_user', $id_user);
stmt->bindParam(':id_cours', $id_cours);
$stmt->execute();

echo "Cours supprimé des suivis.";
?>
