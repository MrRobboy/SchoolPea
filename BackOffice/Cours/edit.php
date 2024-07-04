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
$stmt = $dbh->prepare("SELECT nom, niveau, description FROM COURS where id_COURS = :id");
$stmt->bindvalue(':id', $_GET['id']);
$stmt->execute();
$Cours = $stmt->fetchAll();
$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> EDIT - COURS </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Compte/compte.css">
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/BackOffice/User/edit.css">
</head>

<body style="padding: 7em 0 7em 10em;">
    <?php
    $header = $_SERVER['DOCUMENT_ROOT'];
    $header .= '/BackOffice/Includes/headerBackOffice.php';
    include($header);
    ?>

    <?php if (!empty($_GET['error'])) echo '<p style="background-color: red; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">ERREUR VALEURS ENTREES!</p>'; ?>
    <?php if (!empty($_GET['success'])) echo '<p style="background-color: green; color: white; font-size: 40px; font-weight: 700; padding: 0.5em 1em; border-radius: 3em; text-align: center;">REUSSITE CHANGEMENT</p>'; ?>

    <div id="div1" style="width: 40%;">
        <form method="post" id="Info_gen" style="text-align: left;" action="apply_edit.php">
            <h1 style="text-align: center;">Modifier les infos du Cours</h1>

            <div class="edit">
                <span class="title_edit">ID</span>
                <input type="text" name="id" style="cursor: not-allowed;" class="Input_edit value" value="<?php echo $_GET['id']; ?>" readonly>
            </div>

            <div class="edit">
                <span class="title_edit">Titre</span>
                <input type="text" name="nom" value="<?php echo $Cours[0]['nom']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Niveau</span>
                <input type="text" name="niveau" value="<?php echo $Cours[0]['niveau']; ?>" class="Input_edit value" required>
            </div>

            <div class="edit">
                <span class="title_edit">Description</span>
                <textarea type="text" name="description" style="resize: none;" class="Input_edit value" required><?php echo $Cours[0]['description']; ?></textarea>
            </div>

            <input type="submit" value="Valider les modifications" id="submit">
        </form>
    </div>

</body>

</html>