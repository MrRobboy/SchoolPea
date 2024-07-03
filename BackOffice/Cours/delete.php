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

$stmt = $dbh->prepare("SELECT path_image_pres FROM COURS where id_COURS = :id");
$stmt->bindvalue(':id', $_GET['id']);
$result = $stmt->execute();
$path = $stmt->fetchAll();

$stmt1 = $dbh->prepare("DELETE FROM COURS where id_COURS = :id");
$stmt1->bindvalue(':id', $_GET['id']);
$result1 = $stmt1->execute();

unlink($path[0]['path_image_pres']);

if ($result1) {
    header('Location: https://schoolpea.com/BackOffice/Cours/index.php?success=1');
} else {
    header('Location: https://schoolpea.com/BackOffice/Cours');
}
