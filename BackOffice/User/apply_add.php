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
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo '<pre>';
    print_r($result);
    echo '</pre>';

    if (empty($result[0]['email'])) {

        $passwordHash = password_hash($pass, PASSWORD_DEFAULT);

        $queryStatement = $dbh->prepare('INSERT INTO USER(firstname, lastname, email, pass, validation_mail) VALUES (:firstname, :lastname, :email, :pass,1);');

        $queryStatement->bindvalue(':firstname', $firstname);
        $queryStatement->bindvalue(':lastname', $lastname);
        $queryStatement->bindvalue(':email', $email);
        $queryStatement->bindvalue(':pass', $passwordHash);

        $result1 = $queryStatement->execute();
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error_mail=1');
    }
} else header('Location: https://schoolpea.com');
