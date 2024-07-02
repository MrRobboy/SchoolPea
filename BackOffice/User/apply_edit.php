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

$stmt = $dbh->prepare("SELECT * FROM USER where id_USER=:id");
$stmt->bindvalue(':id', $_POST['id_USER']);
$stmt->execute();
$userInfo = $stmt->fetchAll();

if ($userInfo[0]['id_USER'] == $_POST['id_USER'] and $userInfo[0]['email'] == $_POST['email'] and $userInfo[0]['path_pp'] == $_POST['path_pp'] and $userInfo[0]['firstname'] == $_POST['firstname'] and $userInfo[0]['lastname'] == $_POST['lastname'] and $userInfo[0]['role'] == $_POST['role']) echo '<br>valeurs similaires'/*header('Location: ' . $_SERVER['HTTP_REFERER'])*/;
/*Ici il y a forcément eu une modification ! */
if ($userInfo[0]['email'] != $_POST['email']) {
    $dbh->exec('USE PA');
    $stmt1 = $dbh->prepare("SELECT * FROM USER where email=:email");
    $stmt1->bindvalue(':email', $_POST['email']);
    $stmt1->execute();
    $userExist = $stmt1->fetchAll();

    if ($userExist[0]['email'] == $_POST['email']) {
        $_GET['error_mail'] = 1;
        echo '<br>email error';
        // header('Location: ' . $_SERVER['HTTP_REFERER'] . '&error_mail=1');
    }
}

$stmt2 = $dbh->prepare("UPDATE USER SET lastname=:lastname, firstname=:firstname, email=:email, path_pp=:path_pp, role=:role where id_USER = :id_user");
$stmt2->bindvalue(':id_user', $_POST['id_USER']);
$stmt2->bindvalue(':lastname', $_POST['lastname']);
$stmt2->bindvalue(':firstname', $_POST['firstname']);
$stmt2->bindvalue(':email', $_POST['email']);
$stmt2->bindvalue(':path_pp', $_POST['path_pp']);
$stmt2->bindvalue(':role', $_POST['role']);
$stmt2->execute();
$result = $stmt2->fetchAll();


if ($result) {
    echo 'success';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
    $_GET['success'] = 1;
    echo '<br>success';
    // header('Location: ' . $_SERVER['HTTP_REFERER'] . '&success=1');
} else {
    echo '<pre>';
    print_r($result);
    echo '</pre>';
    $_GET['error'] = 1;
    // header('Location: ' . $_SERVER['HTTP_REFERER'] . '&error=1');
    echo '<br>error wtf';
}
