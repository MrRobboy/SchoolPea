<?php
require_once('db.php');
session_start(); // Démarrage de la session si ce n'est pas déjà fait

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cours'])) {
    $id_cours = $_POST['id_cours'];
    $id_user = $_SESSION['id_user']; // Supposant que vous avez stocké l'ID de l'utilisateur en session

    // Insertion dans la table LIKES_COURS
    $sql = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id_user, $id_cours]);

    // Redirection vers voirCours.php après avoir aimé le cours
    header("Location: voirCours.php?id_cours=$id_cours");
    exit();
} else {
    echo "Erreur: Requête non autorisée.";
}
?>
