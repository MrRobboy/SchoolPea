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
    <title> EDIT - USERS </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Compte/compte.css">
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/BackOffice/User/edit.css">
</head>

<body style="padding: 2em 0 2em 10em;">
    <?php
    $header = $_SERVER['DOCUMENT_ROOT'];
    $header .= '/BackOffice/Includes/headerBackOffice.php';
    include($header);
    ?>

    <div class="container">
        <form method="post" id="Info_gen" action="">
            <h1 style="text-align: center;">Modifier le CAPTCHA</h1>

            <input type="text" name="question" value="<?= $question['question'] ?>" required>
            <label>Réponse:</label>
            <input type="text" name="answer" value="<?= $question['answer'] ?>" required>
            <button type="submit">Modifier</button>
            <div class="edit">
                <span class="title_edit">Id</span>
                <input type="text" name="id_USER" class="Input_edit" style="cursor: not-allowed;" class="value" value="<?php echo $users[0]['id_USER']; ?>" readonly="readonly">
            </div>

            <div class="edit">
                <span class="title_edit">Question</span>
                <input type="text" name="question" value="<?php echo $question[0]['question']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 1 :</span>
                <input type="text" name="question" value="<?php echo $question[0]['reponse1']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 2 :</span>
                <input type="text" name="question" value="<?php echo $question[0]['reponse2']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 3 :</span>
                <input type="text" name="question" value="<?php echo $question[0]['reponse3']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 4 :</span>
                <input type="text" name="question" value="<?php echo $question[0]['reponse4']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 5 :</span>
                <input type="text" name="question" value="<?php echo $question[0]['reponse5']; ?>" class="Input_edit value" required>
            </div>

            <input type="submit" value="Valider les modifications" id="submit">
        </form>
    </div>

</body>

</html>