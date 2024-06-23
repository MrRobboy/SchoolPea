<?php
session_start();
echo $_SESSION['email'];
include('db.php');
echo ($_POST['code'] . '<br>' . $_SESSION['verif']);
if (isset($_POST['submit'])) {
        if ($_POST['code'] == $_SESSION['verif']) {
                $queryStatement = $dbh->prepare('USE PA; INSERT INTO USER(Validé) VALUES (true) where email =' . $_SESSION['email'] . ';');
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
