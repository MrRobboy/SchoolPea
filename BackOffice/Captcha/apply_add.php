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
        $question = htmlspecialchars($_POST['question']);
        $reponse1 = htmlspecialchars($_POST['reponse1']);
        $reponse2 = htmlspecialchars($_POST['reponse2']);
        $reponse3 = htmlspecialchars($_POST['reponse3']);
        $reponse4 = htmlspecialchars($_POST['reponse4']);
        $reponse5 = htmlspecialchars($_POST['reponse5']);

        $dbh->exec('USE PA');

        $stmt = $dbh->prepare("SELECT * FROM  CAPTCHA where question=:question");
        $stmt->bindvalue(':question', $question);
        $stmt->execute();
        $result = $stmt->fetchAll();
        echo '<pre>';
        print_r($result);
        echo '</pre>';

        if (empty($result[0]['question'])) {

                $passwordHash = password_hash($pass, PASSWORD_DEFAULT);

                $queryStatement = $dbh->prepare('INSERT INTO CAPTCHA(question, reponse1, reponse2, reponse3, reponse4, reponse5) VALUES (:question, :reponse1, :reponse2, :reponse3, :reponse4, :reponse5);');

                $queryStatement->bindvalue(':question', $_POST['question']);
                $queryStatement->bindvalue(':reponse1', $_POST['reponse1']);
                $queryStatement->bindvalue(':reponse2', $_POST['reponse2']);
                $queryStatement->bindvalue(':reponse3', $_POST['reponse3']);
                $queryStatement->bindvalue(':reponse4', $_POST['reponse4']);
                $queryStatement->bindvalue(':reponse5', $_POST['reponse5']);

                $result1 = $queryStatement->execute();
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?success=1');
        } else {
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=1');
        }
} else header('Location: https://schoolpea.com');
