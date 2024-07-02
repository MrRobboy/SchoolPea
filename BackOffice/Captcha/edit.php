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
$stmt = $dbh->prepare("SELECT * FROM CAPTCHA where id_CAPTCHA = :id_captcha");
$stmt->bindvalue(':id_captcha', $_GET['id']);
$stmt->execute();
$question = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> EDIT - CAPTCHA </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Compte/compte.css">
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/BackOffice/User/edit.css">
</head>

<body style="padding: 2em 0 2em 10em;">
    <?php
    $header = $_SERVER['DOCUMENT_ROOT'];
    $header .= '/BackOffice/Includes/headerBackOffice.php';
    include($header);
    ?>

    <?php if (!empty($_GET['error'])) echo '<p style="background-color: red; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">ERREUR VALEURS ENTREES!</p>'; ?>
    <?php if (!empty($_GET['success'])) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">REUSSITE CHANGEMENT</p>'; ?>

    <div id="div1" style="width: 40%;">
        <form method="post" id="Info_gen" action="apply_edit.php">
            <h1 style="text-align: center;">Modifier le CAPTCHA</h1>

            <div class="edit">
                <span class="title_edit">Id</span>
                <input type="text" name="id_CAPTCHA" style="cursor: not-allowed;" class="Input_edit value" value="<?php echo $question[0]['id_CAPTCHA']; ?>" readonly>
            </div>

            <div class="edit">
                <span class="title_edit">Question</span>
                <input type="text" name="question" value="<?php echo $question[0]['question']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 1 :</span>
                <input type="text" name="reponse1" value="<?php echo $question[0]['reponse1']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 2 :</span>
                <input type="text" name="reponse2" value="<?php echo $question[0]['reponse2']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 3 :</span>
                <input type="text" name="reponse3" value="<?php echo $question[0]['reponse3']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 4 :</span>
                <input type="text" name="reponse4" value="<?php echo $question[0]['reponse4']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 5 :</span>
                <input type="text" name="reponse5" value="<?php echo $question[0]['reponse5']; ?>" class="Input_edit value" required>
            </div>

            <input type="submit" value="Valider les modifications" id="submit">
        </form>
    </div>

</body>

</html>