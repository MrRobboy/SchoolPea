<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackOffice/Includes/headerBackOffice.php';
include($path);
$dbh->exec('USE PA');
$stmt = $dbh->query("SELECT * FROM LOGS ORDER BY time DESC");
$logs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> LOGS </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Classement/classement.css">
</head>

<body style="padding-left: 4em;">
    <div id="content">
        <h1>Visualisation des Logs</h1>
        <div id="table-classement">
            <table id="classement">
                <thead>
                    <tr>
                        <th style="padding: 0 0.5rem;border-right: solid 0.3rem white;">ID_LOGS</th>
                        <th style="padding: 0 1rem;border-right: solid 0.3rem white;">ID_Utilisateur</th>
                        <th style="padding: 0 5rem;border-right: solid 0.3rem white;">Action</th>
                        <th style="padding: 0 3rem;border-right: none;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log) : ?>
                        <tr>
                            <td class="not_right"><?php echo $log['id_LOGS']; ?></td>
                            <td class="not_right"><?php echo $log['id_user']; ?></td>
                            <td class="not_right"><?php echo $log['act']; ?></td>
                            <td><?php echo $log['time']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>