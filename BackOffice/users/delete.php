<?php
include '../includes/auth.php';
include '../includes/functions.php';

$id = $_GET['id'];

if (delete('users', $id)) {
    header('Location: index.php');
    exit();
} else {
    echo 'Erreur lors de la suppression de l\'utilisateur';
}
?>
