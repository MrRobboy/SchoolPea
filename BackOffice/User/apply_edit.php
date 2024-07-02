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
$stmt = $dbh->prepare("SELECT * FROM USER where email=:email");
$stmt->bindvalue(':email', $_GET['email']);
$stmt->execute();
$userExist = $stmt->fetchAll();

if ($userExist[0]['email'] != $_GET['email']) {

    $stmt2 = $dbh->prepare("UPDATE USER SET lastname=:lastname, firstname=:firstname, email=:email, path_pp=:path_pp where id_USER = :id_user");
    $stmt2->bindvalue(':id_user', $_GET['id']);
    $stmt2->bindvalue(':lastname', $_GET['lastname']);
    $stmt2->bindvalue(':firstname', $_GET['firstname']);
    $stmt2->bindvalue(':email', $_GET['email']);
    $stmt2->bindvalue(':path_pp', $_GET['path_pp']);
    $stmt2->execute();
    $result = $stmt2->fetchAll();

    if ($result) {
        echo 'success';
        echo $result;
    } else {
        echo 'echec';
        echo $result;
    }
}
