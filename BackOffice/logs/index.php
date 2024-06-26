<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);

$stmt = $dbh->query("USE PA; SELECT * FROM LOGS");
$logs = $stmt->fetchAll();
?>

<div class="container" style="margin: auto;">
    <h1>Visualisation des Logs</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID_Utilisateur</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log) : ?>
                <tr>
                    <td><? echo $log['id_LOGS']; ?></td>
                    <td><? echo $log['id_user']; ?></td>
                    <td><? echo $log['act']; ?></td>
                    <td><? echo $log['time']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>