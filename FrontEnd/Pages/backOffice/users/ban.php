<?php
include '../includes/auth.php';
include '../includes/functions.php';

$id = $_GET['id'];

if (update('users', $id, ['status' => 'banned'])) {
    // Envoyer un email de bannissement
    $user = getById('users', $id);
    mail($user['email'], "Vous avez été banni", "Votre compte a été banni.");
    header('Location: index.php');
    exit();
} else {
    echo 'Erreur lors du bannissement de l\'utilisateur';
}
?>
