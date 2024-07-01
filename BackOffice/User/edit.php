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
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/BackOffice/User/edit.css">
</head>

<body style="padding-left: 10em;">
    <?php
    $header = $_SERVER['DOCUMENT_ROOT'];
    $header .= '/BackOffice/Includes/headerBackOffice.php';
    include($header); ?>
    <span class="trait" id="SchoolPea"></span>

    <div id="div1">
        <form method="post" id="Info_gen" action="">
            <h1>Modifier l'Utilisateur</h1>
            <div class="edit">
                <span>Id</span>
                <input type="text" name="id_USER" class="Input_edit" value="<?php echo $users[0]['id_USER']; ?>">
            </div>

            <div class="edit">
                <span>Nom</span>
                <input type="text" name="lastname" class="Input_edit" value="<?php echo $users[0]['lastname']; ?>">
            </div>

            <div class="edit">
                <span>Prenom</span>
                <input type="text" name="firstname" class="Input_edit" value="<?php echo $users[0]['firstname']; ?>">
            </div>

            <div class="edit">
                <span>Email</span>
                <input type="email" name="email" class="Input_edit" value="<?php echo $users[0]['email']; ?>">
            </div>

            <div class="edit">
                <span>Image</span>
                <input type="text" name="path_pp" class="Input_edit" value="<?php echo $users[0]['path_pp']; ?>">
            </div>

            <div class="edit">
                <span>Role</span>
                <input type="radio" value="Admin" <?php if ($users[0]['role'] == 'admin') echo 'checked="checked"'; ?>>
                <input type="radio" value="Professeur" <?php if ($users[0]['role'] == 'professeur') echo 'checked="checked"'; ?>>
                <input type="radio" value="Classique" <?php if ($users[0]['role'] == 'classique') echo 'checked="checked"'; ?>>
            </div>

            <input type="submit" value="Valider les modifications"></input>
        </form>
    </div>
</body>

</html>