<?php
include 'db.php';

$id_cours = $_POST['id_cours'];
$id_user = $_POST['id_user'];

$sql = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (:id_user, :id_cours)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_user', $id_user);
$stmt->bindParam(':id_cours', $id_cours);
$stmt->execute();

echo "Cours liké avec succès.";
?>
