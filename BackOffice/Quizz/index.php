<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$quizzes = getAll('quizzes');
?>

<div class="container">
    <h1>Liste des Quizz</h1>
    <a href="add.php" class="btn">Ajouter un Quizz</a>
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
            <?php foreach ($quizzes as $quizz): ?>
                <tr>
                    <td><?= $quizz['id'] ?></td>
                    <td><?= $quizz['title'] ?></td>
                    <td><?= $quizz['description'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $quizz['id'] ?>" class="btn">Modifier</a>
                        <a href="delete.php?id=<?= $quizz['id'] ?>" class="btn">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
