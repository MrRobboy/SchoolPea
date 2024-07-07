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

$stmt1 = $dbh->prepare("DELETE FROM LOGS where id_USER = :id_user");
$stmt1->bindvalue(':id_user', $_GET['id']);
$result1 = $stmt1->execute();

$stmt2 = $dbh->prepare("DELETE FROM NEWS where sent_by = :id_user");
$stmt2->bindvalue(':id_user', $_GET['id']);
$result2 = $stmt2->execute();

$stmt3 = $dbh->prepare("DELETE FROM TICKET where id_admin = :id_user OR id_client=:id_user");
$stmt3->bindvalue(':id_user', $_GET['id']);
$result3 = $stmt3->execute();

$stmt4 = $dbh->prepare("DELETE FROM messages where author = :id_user");
$stmt4->bindvalue(':id_user', $_GET['id']);
$result4 = $stmt4->execute();

$stmt = $dbh->prepare("DELETE FROM USER where id_USER = :id_user");
$stmt->bindvalue(':id_user', $_GET['id']);
$result = $stmt->execute();

if ($result && $result1 && $result2 && $result3 && $result4) {
    header('Location: https://schoolpea.com/BackOffice/User/index.php?success=1');
} else {
    header('Location: https://schoolpea.com/BackOffice/User');
}
