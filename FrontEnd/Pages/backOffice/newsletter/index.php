<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$newsletters = getAll('newsletters');
?>

<div class="container">
    <h1>Gestion des Newsletters</h1>
    <a href="send.php" class="btn">Envoyer une newsletter</a>
    <h2>Historique des Newsletters</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Date d'envoi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($newsletters as $newsletter): ?>
                <tr>
                    <td><?= $newsletter['id'] ?></td>
                    <td><?= $newsletter['subject'] ?></td>
                    <td><?= $newsletter['message'] ?></td>
                    <td><?= $newsletter['sent_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
