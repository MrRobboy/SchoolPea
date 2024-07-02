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

$stmt = $dbh->prepare("UPDATE USER SET banni = 1 where id_USER=:id_user");
$stmt->bindvalue(':id_user', $_GET['id']);
$result = $stmt->execute();

if ($result) {
    echo 'ban success';
    // header('Location: https://schoolpea.com/BackOffice/User/index.php?success=2');
}
echo 'ban fail';
// header('Location: https://schoolpea.com/BackOffice/User');
