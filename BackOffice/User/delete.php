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
$stmt1->execute();
$result1 = $stmt1->fetchAll();

$stmt2 = $dbh->prepare("DELETE FROM NEWS where sent_by = :id_user");
$stmt2->bindvalue(':id_user', $_GET['id']);
$stmt2->execute();
$result2 = $stmt2->fetchAll();

$stmt3 = $dbh->prepare("DELETE FROM TICKET where id_admin = :id_user OR id_client=:id_user");
$stmt3->bindvalue(':id_user', $_GET['id']);
$stmt3->execute();
$result3 = $stmt3->fetchAll();

$stmt4 = $dbh->prepare("DELETE FROM messages where author = :id_user");
$stmt4->bindvalue(':id_user', $_GET['id']);
$stmt4->execute();
$result4 = $stmt4->fetchAll();

$stmt = $dbh->prepare("DELETE FROM USER where id_USER = :id_user");
$stmt->bindvalue(':id_user', $_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();

if ($result) {
    header('Location: https://schoolpea.com/BackOffice/User/index.php?success=1');
}
header('Location: https://schoolpea.com/BackOffice/User');
