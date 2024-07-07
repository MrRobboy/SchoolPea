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

$stmt1 = $dbh->prepare("SELECT * FROM COURS where id_COURS = :id");
$stmt1->bindvalue(':id', $_POST['id']);
$result1 = $stmt1->execute();
$Cours = $stmt1->fetchAll();

if ($_POST['nom'] == $Cours[0]['nom'] and $_POST['niveau'] == $Cours[0]['niveau'] and $_POST['description'] == $Cours[0]['description']) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {

        $stmt2 = $dbh->prepare("UPDATE COURS SET nom=:nom, niveau=:niveau, description=:description where id_COURS = :id");
        $stmt2->bindvalue(':id', $_POST['id']);
        $stmt2->bindvalue(':nom', $_POST['nom']);
        $stmt2->bindvalue(':niveau', $_POST['niveau']);
        $stmt2->bindvalue(':description', $_POST['description']);
        $result2 = $stmt2->execute();


        if ($result2 && $result1) {
                $_GET['success'] = 1;
                echo '<br>success';
                header('Location: https://schoolpea.com/BackOffice/Cours/edit.php?success=1');
        } else {
                echo $result;
                echo '<br>error wtf';
                $_GET['error'] = 1;
                header('Location: https://schoolpea.com/BackOffice/Cours/edit.php?error=1');
        }
}
