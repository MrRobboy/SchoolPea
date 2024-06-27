<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackOffice/Includes/headerBackOffice.php';
include($path);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);


$dbh->exec('USE PA');
$stmt = $dbh->query("SELECT * FROM USER");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> USERS </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Classement/classement.css">
</head>

<body>
    <div id="content" style="width: 95%;">
        <h1 style="margin-bottom: 0.5em;">Gestion des Utilisateurs</h1>
        <a href="add.php" class="btn add">Ajouter un utilisateur</a>
        <div id="table-classement" style="margin-top: 3em;">
            <table id="classement">
                <thead>
                    <tr>
                        <th style="padding: 0 0.5rem;border-right: solid 0.3rem white;">ID</th>
                        <th style="padding: 0 3rem;border-right: solid 0.3rem white;">Nom</th>
                        <th style="padding: 0 3rem;border-right: solid 0.3rem white;">Prenom</th>
                        <th style="padding: 0 4rem;border-right: solid 0.3rem white;">Email</th>
                        <th style="padding: 0 1rem;border-right: solid 0.3rem white;">Rôle</th>
                        <th style="padding: 0 4rem;border-right: none;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td class="not_right"><?php echo $user['id_USER']; ?></td>
                            <td class="not_right"><?php echo $user['lastname']; ?></td>
                            <td class="not_right"><?php echo $user['firstname']; ?></td>
                            <td class="not_right"><?php echo $user['email']; ?></td>
                            <td class="not_right"><?php echo $user['role']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $user['id_USER']; ?>" class="btn modify">Modifier</a>
                                <?php if ($user['role'] != 'admin') echo "<a href='ban.php?id=" . $user['id_USER'] . "' class='btn ban'>Bannir</a>" ?>
                                <a href="delete.php?id=<?php echo $user['id_USER']; ?>" class="btn del">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>