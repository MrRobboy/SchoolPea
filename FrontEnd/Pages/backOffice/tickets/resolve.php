<?php
include '../includes/auth.php';
include '../includes/functions.php';

$id = $_GET['id'];

if (update('tickets', $id, ['status' => 'resolved'])) {
    header('Location: index.php');
    exit();
} else {
    echo 'Erreur lors de la résolution du ticket';
}
?>
