<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo "Vous devez être connecté pour effectuer cette action.";
    exit();
}

include 'db.php'; // Inclure le fichier de connexion à la base de données

// Récupérer les données du formulaire POST
$id_cours = $_POST['id_cours'];
$id_user = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur à partir de la session

// Vérifier si l'utilisateur suit déjà ce cours
$sql_check = "SELECT * FROM LIKES_COURS WHERE id_user = :id_user AND id_cours = :id_cours";
$stmt_check = $dbh->prepare($sql_check);
$stmt_check->bindParam(':id_user', $id_user);
$stmt_check->bindParam(':id_cours', $id_cours);
$stmt_check->execute();

if ($stmt_check->rowCount() > 0) {
    http_response_code(400); // Bad request
    echo "Vous suivez déjà ce cours.";
    exit();
}

// Ajouter l'entrée de suivi dans la base de données
$sql_insert = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (:id_user, :id_cours)";
$stmt_insert = $dbh->prepare($sql_insert);
$stmt_insert->bindParam(':id_user', $id_user);
$stmt_insert->bindParam(':id_cours', $id_cours);
$stmt_insert->execute();

echo "Cours suivi avec succès.";
?>
