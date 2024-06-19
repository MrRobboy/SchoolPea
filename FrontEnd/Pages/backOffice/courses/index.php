<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$courses = getAll('courses');
?>

<div class="container">
    <h1>Liste des Cours</h1>
    <a href="add.php" class="btn">Ajouter un Cours</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= $course['id'] ?></td>
                    <td><?= $course['title'] ?></td>
                    <td><?= $course['description'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $course['id'] ?>" class="btn">Modifier</a>
                        <a href="delete.php?id=<?= $course['id'] ?>" class="btn">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
