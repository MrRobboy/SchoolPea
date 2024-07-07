<?php
session_start();

$_GET;

$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

$dbh->exec('USE PA');

$stmt1 = $dbh->prepare("DELETE FROM CAPTCHA where id_CAPTCHA = :id_CAPTCHA");
$stmt1->bindvalue(':id_CAPTCHA', $_GET['id']);
$result1 = $stmt1->execute();

if ($result1) {
    header('Location: https://schoolpea.com/BackOffice/Captcha/index.php?success=1');
} else {
    header('Location: https://schoolpea.com/BackOffice/Captcha');
}
