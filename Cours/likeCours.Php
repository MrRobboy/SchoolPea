<?php
require_once('db.php');

session_start(); // Start session if not already started

if (isset($_GET['id_cours'])) {
    $id_cours = $_GET['id_cours'];
    $id_user = $_SESSION['id_user']; // Assuming you have stored user ID in session

    // Insert into LIKES_COURS table
    $sql = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id_user, $id_cours]);

    // Redirect back to voirCours.php after liking
    header("Location: voirCours.php?id_cours=$id_cours");
    exit();
} else {
    echo "Erreur: ID de cours non spécifié.";
}
?>
