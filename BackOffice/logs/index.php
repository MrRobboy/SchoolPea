<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);

$stmt = $dbh->query("SELECT * FROM LOGS");
$logs = $stmt->fetchAll();
echo ('<pre>');
print_r($logs);
echo ('</pre>');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> LOGS </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Classement/classement.css">
</head>

<body>
    <div class="container" style="margin: auto;">
        <h1>Visualisation des Logs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID_LOGS</th>
                    <th>ID_Utilisateur</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log) : ?>
                    <tr>
                        <td><?php echo $log['id_LOGS']; ?></td>
                        <td><?php echo $log['id_user']; ?></td>
                        <td><?php echo $log['act']; ?></td>
                        <td><?php echo $log['time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>