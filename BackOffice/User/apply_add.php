<?php
session_start();
$_GET;
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);


if (isset($_POST['submit'])) {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $pass = htmlspecialchars($_POST['password']);

    $dbh->exec('USE PA');

    $stmt = $dbh->prepare("SELECT * FROM  USER where email=:email");
    $stmt->bindvalue(':email', $email);
    $result = $stmt->execute();

    if ($email == $_POST['email']) header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error_mail=1');
    else {
        $passwordHash = password_hash($pass, PASSWORD_DEFAULT);

        $queryStatement = $dbh->prepare('INSERT INTO USER(firstname, lastname, email, pass, mail, validation_mail) VALUES (:firstname, :lastname, :email, :pass,1);');

        $queryStatement->bindvalue(':firstname', $firstname);
        $queryStatement->bindvalue(':lastname', $lastname);
        $queryStatement->bindvalue(':email', $email);
        $queryStatement->bindvalue(':pass', $passwordHash);

        $result1 = $queryStatement->execute();
        echo 'Le mail est validé d\'office !';
    }
} else header('Location: https:schoolpea.com');
