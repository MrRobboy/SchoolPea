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
$stmt = $dbh->prepare("SELECT * FROM USER where email=:email");
$stmt->bindvalue(':email', $_POST['email']);
$stmt->execute();
$userExist = $stmt->fetchAll();

if ($userExist[0]['email'] != $_POST['email']) {

    $stmt2 = $dbh->prepare("UPDATE USER SET lastname=:lastname, firstname=:firstname, email=:email, path_pp=:path_pp where id_USER = :id_user");
    $stmt2->bindvalue(':id_user', $_POST['id_USER']);
    $stmt2->bindvalue(':lastname', $_POST['lastname']);
    $stmt2->bindvalue(':firstname', $_POST['firstname']);
    $stmt2->bindvalue(':email', $_POST['email']);
    $stmt2->bindvalue(':path_pp', $_POST['path_pp']);
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
$_GET['error'] = 1;
header('Location: ' . $_SERVER['HTTP_REFERER'] . '&error=1');
