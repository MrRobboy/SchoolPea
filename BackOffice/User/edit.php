<?php
session_start();
$_GET;
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

$dbh->exec('USE PA');
$stmt = $dbh->prepare("SELECT * FROM USER where id_USER = :id_user");
$stmt->bindvalue(':id_user', $_GET['id']);
$stmt->execute();
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> EDIT - USERS </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Compte/compte.css">
</head>

<body>
    <?php
    $header = $_SERVER['DOCUMENT_ROOT'];
    $header .= '/BackOffice/Includes/headerBackOffice.php';
    include($header); ?>
    <div id="Info_gen">
        <h1>Modifier l'Utilisateur</h1>
        <form method="post">
            <div>
                <span>Id</span>
                <input type="text" value="<?php echo $users[0]['id_USER']; ?>">
            </div>

            <div>
                <span>Nom</span>
                <input type="text" value="<?php echo $users[0]['lastname']; ?>">
            </div>

            <div>
                <span>Prenom</span>
                <input type="text" value="<?php echo $users[0]['firstname']; ?>">
            </div>

            <div>
                <span>Email</span>
                <input type="email" value="<?php echo $users[0]['email']; ?>">
            </div>

            <div>
                <span>Image</span>
                <input type="text" value="<?php echo $users[0]['path_pp']; ?>">
            </div>

            <div>
                <span>Role</span>
                <input type="radio" value="<?php echo $users[0]['role']; ?>">
            </div>

            <input type="submit">Valider les modifications</input>
        </form>
    </div>
</body>

</html>