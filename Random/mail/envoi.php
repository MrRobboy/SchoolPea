<?php
include_once('fonctions.php');

if (isset($_POST['sujet']) && isset($_POST['message']) && isset($_POST['destination']))
    sendmail($_POST['sujet'], $_POST['message'], $_POST['destination']);
else {
    header('Location: newsletter.php');
    echo ("erreur de saise!");
}
