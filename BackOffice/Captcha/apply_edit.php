<?php
session_start();

$_POST;

$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

echo '<pre>';
print_r($_POST);
echo '</pre>';

$dbh->exec('USE PA');

$stmt1 = $dbh->prepare("SELECT * FROM CAPTCHA where id_CAPTCHA = :id_captcha");
$stmt1->bindvalue(':id_captcha', $_POST['id_CAPTCHA']);
$result1 = $stmt1->execute();
$question = $stmt1->fetchAll();

if ($_POST['question'] == $question[0]['question'] and $_POST['reponse1'] == $question[0]['reponse1'] and $_POST['reponse2'] == $question[0]['reponse2'] and $_POST['reponse3'] == $question[0]['reponse3'] and $_POST['reponse4'] == $question[0]['reponse4'] and $_POST['reponse5'] == $question[0]['reponse5']) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {

        $stmt2 = $dbh->prepare("UPDATE CAPTCHA SET question=:question, reponse1=:reponse1, reponse2=:reponse2, reponse3=:reponse3, reponse4=:reponse4, reponse5=:reponse5 where id_CAPTCHA = :id_captcha");
        $stmt2->bindvalue(':id_captcha', $_POST['id_CAPTCHA']);
        $stmt2->bindvalue(':question', $_POST['question']);
        $stmt2->bindvalue(':reponse1', $_POST['reponse1']);
        $stmt2->bindvalue(':reponse2', $_POST['reponse2']);
        $stmt2->bindvalue(':reponse3', $_POST['reponse3']);
        $stmt2->bindvalue(':reponse4', $_POST['reponse4']);
        $stmt2->bindvalue(':reponse5', $_POST['reponse5']);
        $result2 = $stmt2->execute();


        if ($result2 && $result1) {
                $_GET['success'] = 1;
                echo '<br>success';
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '&success=1');
        } else {
                echo $result;
                echo '<br>error wtf';
                $_GET['error'] = 1;
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '&error=1');
        }
}
