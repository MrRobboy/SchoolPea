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

<body style="padding: 10em 0 10em 10em;">
    <?php
    $header = $_SERVER['DOCUMENT_ROOT'];
    $header .= '/BackOffice/Includes/headerBackOffice.php';
    include($header); ?>
    <span class="trait" id="SchoolPea"></span>

    <?php if (!empty($_GET['Error'])) echo 'MAIL DEJA EXISTANT!'; ?>

    <div id="div1">
        <form method="post" id="Info_gen" action="apply_edit.php">
            <h1 style="text-align: center;">Modifier l'Utilisateur</h1>
            <div class="edit">
                <span class="title_edit">Id</span>
                <input type="text" name="id_USER" class="Input_edit" style="cursor: not-allowed;" class="value" value="<?php echo $users[0]['id_USER']; ?>" readonly="readonly">
            </div>

            <div class="edit">
                <span class="title_edit">Nom</span>
                <input type="text" name="lastname" class="Input_edit" class="value" value="<?php echo $users[0]['lastname']; ?>">
            </div>

            <div class="edit">
                <span class="title_edit">Prenom</span>
                <input type="text" name="firstname" class="Input_edit" class="value" value="<?php echo $users[0]['firstname']; ?>">
            </div>

            <div class="edit">
                <span class="title_edit">Email</span>
                <input type="email" name="email" class="Input_edit" class="value" value="<?php echo $users[0]['email']; ?>">
            </div>

            <div class="edit">
                <span class="title_edit">Image</span>
                <input type="text" name="path_pp" class="Input_edit" class="value" value="<?php echo $users[0]['path_pp']; ?>">
            </div>

            <div class="edit">
                <span class="title_edit">Role : </span>
                <div class="boutton">
                    <label for="male">Admin</label>
                    <input type="radio" value="admin" name="role" <?php if ($users[0]['role'] == 'admin') echo 'checked="checked"'; ?>>
                </div>
                <div class="boutton">
                    <label for="male">Professeur</label>
                    <input type="radio" value="professeur" name="role" <?php if ($users[0]['role'] == 'professeur') echo 'checked="checked"'; ?>>
                </div>
                <div class="boutton">
                    <label for="male">Classique</label>
                    <input type="radio" value="classique" name="role" <?php if ($users[0]['role'] == 'classique') echo 'checked="checked"'; ?>>
                </div>
            </div>

            <input type="submit" value="Valider les modifications" id="submit">
        </form>
    </div>
</body>

</html>