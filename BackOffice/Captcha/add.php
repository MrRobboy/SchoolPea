<?php
session_start();
$_GET;
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> ADD - CAPTCHA </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Compte/compte.css">
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/BackOffice/User/edit.css">
</head>

<body style="padding: 2em 0 2em 10em;">
    <?php
    $header = $_SERVER['DOCUMENT_ROOT'];
    $header .= '/BackOffice/Includes/headerBackOffice.php';
    include($header);
    ?>

    <?php if (!empty($_GET['error'])) echo '<p style="background-color: red; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">Question déjà existante!</p>'; ?>
    <?php if (!empty($_GET['success'])) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">REUSSITE AJOUT CAPTCHA</p>'; ?>

    <div id="div1" style="width: 40%;">
        <form method="post" id="Info_gen" action="apply_add.php">
            <h1 style="text-align: center;">Ajouter un CAPTCHA</h1>

            <div class="edit">
                <span class="title_edit">Question</span>
                <input type="text" name="question" placeholder="Question" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 1 :</span>
                <input type="text" name="reponse1" placeholder="Réponse 1" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 2 :</span>
                <input type="text" name="reponse2" placeholder="Réponse 2" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 3 :</span>
                <input type="text" name="reponse3" placeholder="Réponse 3" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 4 :</span>
                <input type="text" name="reponse4" placeholder="Réponse 4" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Réponse 5 :</span>
                <input type="text" name="reponse5" placeholder="Réponse 5" class="Input_edit value" required>
            </div>

            <input type="submit" name="submit" value="Valider les modifications" id="submit">
        </form>
    </div>

</body>

</html>