<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$tickets = getAll('tickets');
?>

<div class="container">
    <h1>Gestion des Tickets</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Utilisateur</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= $ticket['id'] ?></td>
                    <td><?= $ticket['user_id'] ?></td>
                    <td><?= $ticket['subject'] ?></td>
                    <td><?= $ticket['message'] ?></td>
                    <td><?= $ticket['status'] ?></td>
                    <td>
                        <a href="resolve.php?id=<?= $ticket['id'] ?>" class="btn">Résoudre</a>
                        <a href="delete.php?id=<?= $ticket['id'] ?>" class="btn">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
