<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackOffice/Includes/headerBackOffice.php';
include($path);
$dbh->exec('USE PA');
$stmt = $dbh->query("SELECT * FROM COURS");
$courss = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> COURS </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Classement/classement.css">
</head>

<body style="padding-left: 10em;">
    <?php if (!empty($_GET['error'])) echo '<p style="background-color: red; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">ERREUR VALEURS ENTREES!</p>'; ?>
    <?php if (!empty($_GET['success']) && $_GET['success'] == 1) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">REUSSITE SUPPRESSION COURS</p>'; ?>
    <?php if (!empty($_GET['success']) && $_GET['success'] == 2) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">REUSSITE AJOUT COURS</p>'; ?>

    <div id="content" style="width: 95%;">
        <h1 style="margin-bottom: 0.5em;">Gestion des Cours</h1>
        <a href="https://schoolpea.com/Cours/creerCours.php" class="btn add">Ajouter un Cours </a>
        <div id="table-classement" style="margin-top: 3em;">
            <table id="classement">
                <thead>
                    <tr>
                        <th style="padding: 0 0.5rem;border-right: solid 0.3rem white;">ID</th>
                        <th style="padding: 0 3.5rem;border-right: solid 0.3rem white;">Titre</th>
                        <th style="padding: 0 0.7rem;border-right: solid 0.3rem white;">Difficulté </th>
                        <th style="padding: 0 0.7rem;border-right: solid 0.3rem white;">Description</th>
                        <th style="padding: 0 6rem;border-right: none;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courss as $cours) : ?>
                        <tr>
                            <td class="not_right"><?php echo $cours['id_COURS']; ?></td>
                            <td class="not_right"><?php echo $cours['nom']; ?></td>
                            <td class="not_right"><?php echo $cours['niveau']; ?></td>
                            <td class="not_right"><?php echo $cours['description']; ?></td>

                            <td>
                                <a href="edit.php?id=<?php echo $cours['id_COURS']; ?>" class="btn modify">Modifier</a>
                                <a href="confirm_delete.php?id=<?php echo $cours['id_COURS']; ?>" class="btn del">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>