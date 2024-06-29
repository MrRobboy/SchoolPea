<?php
session_start();
include 'db.php'; // Inclure le fichier de connexion à la base de données

$sql = "SELECT MESSAGE.message, MESSAGE.sent_at, USER.email, USER.path_pp 
        FROM MESSAGE 
        JOIN USER ON MESSAGE.sent_by = USER.id_USER 
        ORDER BY MESSAGE.sent_at DESC";

$stmt = $dbh->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fermer la connexion PDO
$stmt = null;
$dbh = null;

echo json_encode($messages);
?>
