<?php
session_start();

$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
?>
<script>
    if (confirm("Êtes-vous sûr de vouloir Bannir cet utilisateur ?") !== true) {
        window.location.href = document.referrer;
    }
</script>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Confirmation banissement USER</title>
</head>

<body style="padding: 5em;">
    <div style="margin: 0 auto; justify-content: center;align-items: center; text-align: center;">
        <h1 style="margin: 3em 0;">Bannir l'utilisateur : <?php echo $_GET['id'] ?></h1>
        <a style="text-align: center; margin:5em; padding: 0.5em 1em; font-size: 20px; font-weight: 400; text-decoration: none; background-color: red; color: white; border-radius: 1em;" href="ban.php?id=<?php echo $_GET['id']; ?>"> Bannir l'utilisateur</a>
        <a style="text-align: center; margin:5em; padding: 0.5em 1em; font-size: 20px; font-weight: 400; text-decoration: none; background-color: green; color: white; border-radius: 1em;" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"> Annuler le banissement</a>
    </div>
</body>

</html>