<?php
session_start();
include('db.php');
if (!empty($_POST['submit'])) {
        echo ($_POST['code'] . '<br>' . $_SESSION['verif']);
        if ($_POST['code'] == $_SESSION['verif']) {
                $queryStatement = $dbh->prepare('USE PA; INSERT INTO USER(Validé) VALUES (true);');
                $result = $queryStatement->execute();
                echo ('code reussi !!');
                // header('location: captcha.php');
        } else {
                echo ('code echoué :(');
                // header('location: ./message_verification.php');
        }
} else {
        echo ('ERREUR SUBMIT');
        // header('location: ' . $_SERVER['DOCUMENT_ROOT']);
        echo ($_POST['submit']);
}
