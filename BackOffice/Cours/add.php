<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (create('courses', ['title' => $title, 'description' => $description])) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors de l\'ajout du cours';
    }
}
?>

<div class="container">
    <h1>Ajouter un Cours</h1>
    <form method="post">
        <label>Titre:</label>
        <input type="text" name="title" required>
        <label>Description:</label>
        <textarea name="description" required></textarea>
        <button type="submit">Ajouter</button>
    </form>
</div>