<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);

$questions = getAll('captcha_questions');
?>

<div class="container">
    <h1>Gestion des Questions CAPTCHA</h1>
    <a href="add.php" class="btn">Ajouter une question</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Réponse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question) : ?>
                <tr>
                    <td><?= $question['id'] ?></td>
                    <td><?= $question['question'] ?></td>
                    <td><?= $question['answer'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $question['id'] ?>" class="btn">Modifier</a>
                        <a href="delete.php?id=<?= $question['id'] ?>" class="btn">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>