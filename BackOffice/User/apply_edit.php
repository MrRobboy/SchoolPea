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
$stmt = $dbh->prepare("SELECT * FROM USER");
$stmt->bindvalue(':id_user', $_GET['id']);
$stmt->bindvalue(':id_user', $_GET['id']);
$stmt->execute();
$users = $stmt->fetchAll();

$stmt = $dbh->prepare("UPDATE USER SET lastname=:lastname, firstname=:firstname, email=:email, path_pp=:path_pp where id_USER = :id_user");
$stmt->bindvalue(':id_user', $_GET['id']);
$stmt->bindvalue(':id_user', $_GET['id']);
$stmt->execute();
$users = $stmt->fetchAll();
