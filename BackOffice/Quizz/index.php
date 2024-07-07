<?php
session_start();

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackOffice/Includes/headerBackOffice.php';
include($path);

$dbh->exec('USE PA');

$stmt = $dbh->query("SELECT * FROM QUIZZ");
$quizzes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>QUIZZ</title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Classement/classement.css">
</head>

<body style="padding-left: 10em;">
    <?php if (!empty($_GET['error'])) echo '<p style="background-color: red; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">ERREUR VALEURS ENTREES!</p>'; ?>
    <?php if (!empty($_GET['success']) && $_GET['success'] == 1) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">REUSSITE SUPPRESSION QUIZ</p>'; ?>
    <?php if (!empty($_GET['success']) && $_GET['success'] == 2) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">REUSSITE AJOUT QUIZ</p>'; ?>

    <div id="content" style="width: 95%;">
        <h1 style="margin-bottom: 0.5em;">Gestion des Quizzs</h1>
        <a href="https://schoolpea.com/Quizzs/createQuizz.php" class="btn add">Ajouter un Quizz</a>
        <div id="table-classement" style="margin-top: 3em;">
            <table id="classement">
                <thead>
                    <tr>
                        <th style="padding: 0 0.5rem;border-right: solid 0.3rem white;">ID</th>
                        <th style="padding: 0 3.5rem;border-right: solid 0.3rem white;">Titre</th>
                        <th style="padding: 0 0.7rem;border-right: solid 0.3rem white;">Description</th>
                        <th style="padding: 0 6rem;border-right: none;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quizzes as $quiz) : ?>
                        <tr>
                            <td class="not_right"><?php echo $quiz['id_QUIZZ']; ?></td>
                            <td class="not_right"><?php echo $quiz['nom']; ?></td>
                            <td class="not_right"><?php echo $quiz['description']; ?></td>

                            <td>
                                <a href="edit.php?id=<?php echo $quiz['id_QUIZZ']; ?>" class="btn modify">Modifier</a>
                                <a href="confirm_delete.php?id=<?php echo $quiz['id_QUIZZ']; ?>" class="btn del">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>