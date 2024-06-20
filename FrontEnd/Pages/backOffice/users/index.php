<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$users = getAll('users');
?>

<div class="container">
    <h1>Gestion des Utilisateurs</h1>
    <a href="add.php" class="btn">Ajouter un utilisateur</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $user['id'] ?>" class="btn">Modifier</a>
                        <a href="ban.php?id=<?= $user['id'] ?>" class="btn">Bannir</a>
                        <a href="delete.php?id=<?= $user['id'] ?>" class="btn">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
