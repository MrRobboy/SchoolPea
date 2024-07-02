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

<a style="text-align: center; padding: 2em; font-size: 30px; font-weight: 600; text-decoration: none; background-color: red; color: white; border-radius: 1em;" href="#"> Supprimer l'utilisateur</a>
<a style="text-align: center; padding: 2em; font-size: 30px; font-weight: 600; text-decoration: none; background-color: green; color: white; border-radius: 1em;" href="?"> Annuler la suppression</a>

<?php


?>