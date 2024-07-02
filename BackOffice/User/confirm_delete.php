<?php
session_start();
$_GET;
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);
?>
<script>
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?") !== true) {
        window.location.href = document.referrer;
    }
</script>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Confirmation Supression USER</title>
</head>

<body style="padding: 5em;">
    <div style="margin: 0 auto; justify-content: center;align-items: center; text-align: center;">
        <h1 style="margin: 3em 0;">Supprimer l'utilisateur : <?php echo $_GET['id'] ?></h1>
        <a style="text-align: center; margin:5em; padding: 0.5em 1em; font-size: 20px; font-weight: 400; text-decoration: none; background-color: red; color: white; border-radius: 1em;" href="delete.php?id=<?php echo $_GET['id']; ?>"> Supprimer l'utilisateur</a>
        <a style="text-align: center; margin:5em; padding: 0.5em 1em; font-size: 20px; font-weight: 400; text-decoration: none; background-color: green; color: white; border-radius: 1em;" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"> Annuler la suppression</a>
    </div>
</body>

</html>