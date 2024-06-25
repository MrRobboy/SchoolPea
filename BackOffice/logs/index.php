<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$logs = getAll('logs');
?>

<div class="container">
    <h1>Visualisation des Logs</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Utilisateur</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= $log['id'] ?></td>
                    <td><?= $log['user_id'] ?></td>
                    <td><?= $log['action'] ?></td>
                    <td><?= $log['timestamp'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
