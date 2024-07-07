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

$stmt1 = $dbh->prepare("SELECT * FROM QUIZZ WHERE id_QUIZZ = :id");
$stmt1->bindValue(':id', $_POST['id']);
$result1 = $stmt1->execute();
$quiz = $stmt1->fetchAll();

if ($quiz && $_POST['nom'] == $quiz[0]['nom'] && $_POST['niveau'] == $quiz[0]['niveau'] && $_POST['description'] == $quiz[0]['description']) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {

        $stmt2 = $dbh->prepare("UPDATE QUIZZ SET nom = :nom, description = :description WHERE id_QUIZZ = :id");
    $stmt2->bindValue(':id', $_POST['id']);
    $stmt2->bindValue(':nom', $_POST['nom']);
    $stmt2->bindValue(':description', $_POST['description']);
    $result2 = $stmt2->execute();

    if ($result2 && $result1) {
        $_GET['success'] = 1;
        echo '<br>success';
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '&success=1');
    } else {
        echo $result2;
        echo '<br>error wtf';
        $_GET['error'] = 1;
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '&error=1');
    }
}
?>
