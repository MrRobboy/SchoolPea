<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);

$logs = getAll('LOGS');
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
            <?php foreach ($logs as $log) : ?>
                <tr>
                    <td><?= $log['id_LOGS'] ?></td>
                    <td><?= $log['id_user'] ?></td>
                    <td><?= $log['act'] ?></td>
                    <td><?= $log['time'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>