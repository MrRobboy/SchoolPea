<?php
session_start();
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

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
        <h1>Gestion des Utilisateurs</h1>
        <a href="add.php" class="btn">Ajouter un utilisateur</a>
        <div id="table-classement">
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
                                <a href="ban.php?id=<?php echo $user['id_USER']; ?>" class="btn ban">Bannir</a>
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