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
$stmt = $dbh->prepare("DELETE FROM USER where id_USER = :id_user");
$stmt->bindvalue(':id_user', $_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();

$path = '';
if ($result) {
    $path = 'success=1';
}
header('Location: https://schoolpea.com/BackOffice/User/index.php?' . $path);
