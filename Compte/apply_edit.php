<?php
session_start();
$_POST;
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

$path = $_SERVER['DOCUMENT_ROOT'];
if (empty($_SESSION['mail_valide'])) {
    header('Location: https://schoolpea.com/Connexion');
}

$target_dir = "/var/www/html/SchoolPea/Images/PP_IMAGES/";
$fileName = uniqid();
$target_file = $target_dir . $fileName;

echo '<br>';
echo 'FILES<pre>';
print_r($_FILES);
echo '</pre>';

echo 'POST<pre>';
print_r($_POST);
echo '</pre>';

echo 'SESSION<pre>';
print_r($_SESSION);
echo '</pre>';

$dbh->exec('USE PA');

$stmt = $dbh->prepare("SELECT * FROM USER where id_USER=:id");
$stmt->bindvalue(':id', $_SESSION['id_user']);
$stmt->execute();
$userInfo = $stmt->fetchAll();

echo 'INFO USER<pre>';
print_r($userInfo);
echo '</pre>';



$fileUploaded = false;
$CorrectName = str_replace(' ', '_', $_FILES["img_pp"]["name"]);
$CorrectName = str_replace('\'', '_', $_FILES["img_pp"]["name"]);

echo 'CORRECT NAME : ' . $CorrectName;

if (!empty($_FILES['img_pp'])) {
    $fileName .= "_" . $CorrectName;
    echo '<br>TARGET FILE NAME : ' . $fileName;
    if ($_FILES["img_pp"]["size"] > 0 && is_uploaded_file($_FILES["img_pp"]["tmp_name"])) {
        $fileUploaded = true;
        $target_storage = "https://schoolpea.com/Images/PP_IMAGES/" . $fileName;
        if (!move_uploaded_file($_FILES["img_pp"]["tmp_name"], $target_file)) echo 'Erreur téléchargement !';
    } else {
        $target_storage = $userInfo[0]['path_pp'];
    }
} else {
    $target_storage = $userInfo[0]['path_pp'];
}

echo '<br>TARGET DIR : ' . $target_dir;
echo '<br>TARGET FILE : ' . $target_file;
echo '<br>TARGET STORAGE : ' . $target_storage;

if ($userInfo[0]['email'] == $_POST['email'] and !$fileUploaded and $userInfo[0]['firstname'] == $_POST['firstname'] and $userInfo[0]['lastname'] == $_POST['lastname']) {
    echo '<br>valeurs similaires';
    // header('Location: https://schoolpea.com/Compte/index.php');
} else {
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
            header('Location: https://schoolpea.com/Compte/index.php?error_mail=1');
        }
    }

    $stmt2 = $dbh->prepare("UPDATE USER SET lastname=:lastname, firstname=:firstname, email=:email, path_pp=:path_pp where id_USER = :id_user");
    $stmt2->bindvalue(':id_user', $_SESSION['id_user']);
    $stmt2->bindvalue(':lastname', $_POST['lastname']);
    $stmt2->bindvalue(':firstname', $_POST['firstname']);
    $stmt2->bindvalue(':email', $_POST['email']);
    $stmt2->bindvalue(':path_pp', $target_storage);
    $result = $stmt2->execute();


    if ($result) {
        echo '<br>' . $result;
        $_GET['success'] = 1;
        echo '<br>success';
        // header('Location: https://schoolpea.com/Compte/index.php?success=1');
    } else {
        echo $result;
        echo '<br>error wtf';
        $_GET['error'] = 1;
        header('Location: https://schoolpea.com/Compte/index.php?error=1');
    }
}
