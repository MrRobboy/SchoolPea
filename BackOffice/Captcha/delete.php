<?php
include '../includes/auth.php';
include '../includes/functions.php';

$id = $_GET['id'];

if (delete('captcha_questions', $id)) {
    header('Location: index.php');
    exit();
} else {
    echo 'Erreur lors de la suppression de la question';
}
?>
