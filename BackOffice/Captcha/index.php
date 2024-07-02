<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackOffice/Includes/headerBackOffice.php';
include($path);
$dbh->exec('USE PA');
$stmt = $dbh->query("SELECT * FROM CAPTCHA");
$questions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> Captcha </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Classement/classement.css">
</head>

<?php if (!empty($_GET['success']) && $_GET['success'] == 1) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">Captcha supprimé avec succès!</p>'; ?>
<?php if (!empty($_GET['success']) && $_GET['success'] == 2) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">Captcha ajouté avec succès!</p>'; ?>

<body style="padding-left: 10em;">
    <div id="content" style="width: 95%;">
        <h1 style="margin-bottom: 0.5em;">Gestion du Captcha</h1>
        <a href="add.php" class="btn add">Ajouter une question</a>
        <div id="table-classement" style="margin-top: 3em;">
            <table id="classement">
                <thead>
                    <tr>
                        <th style="padding: 0 0.5rem;border-right: solid 0.3rem white;">ID</th>
                        <th style="padding: 0 3.5rem;border-right: solid 0.3rem white;">Question</th>
                        <th style="padding: 0 0.7rem;border-right: solid 0.3rem white;">Reponse1</th>
                        <th style="padding: 0 0.7rem;border-right: solid 0.3rem white;">Reponse2</th>
                        <th style="padding: 0 0.7rem;border-right: solid 0.3rem white;">Reponse3</th>
                        <th style="padding: 0 0.7rem;border-right: solid 0.3rem white;">Reponse4</th>
                        <th style="padding: 0 0.7rem;border-right: solid 0.3rem white;">Reponse5</th>
                        <th style="padding: 0 6rem;border-right: none;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $question) : ?>
                        <tr>
                            <td class="not_right"><?php echo $question['id_CAPTCHA']; ?></td>
                            <td class="not_right"><?php echo $question['question']; ?></td>
                            <td class="not_right"><?php echo $question['reponse1']; ?></td>
                            <td class="not_right"><?php echo $question['reponse2']; ?></td>
                            <td class="not_right"><?php echo $question['reponse3']; ?></td>
                            <td class="not_right"><?php echo $question['reponse4']; ?></td>
                            <td class="not_right"><?php echo $question['reponse5']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $question['id_CAPTCHA']; ?>" class="btn modify">Modifier</a>
                                <a href="confirm_delete.php?id=<?php echo $question['id_CAPTCHA']; ?>" class="btn del">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>