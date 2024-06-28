<?php
require_once('db.php');

session_start(); // Start session if not already started

// Assuming you have stored user ID in session
$id_user = $_SESSION['id_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cours = $_POST['id_cours'];

    // Supprimer le like de la base de données
    $sql = "DELETE FROM LIKES_COURS WHERE id_user = :id_user AND id_cours = :id_cours";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_cours', $id_cours);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Cours retiré de vos suivis avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors du retrait du cours.";
    }

    // Rediriger l'utilisateur vers la page des cours aimés
    header('Location: likedCourses.php');
    exit();
} else {
    echo "Requête invalide.";
}
?>
