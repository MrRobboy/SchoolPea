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
$dbh->beginTransaction();

try {
    // Supprimer les questions associées au quiz
    $stmt_delete_questions = $dbh->prepare("DELETE FROM QUESTIONS WHERE id_quizz = :id");
    $stmt_delete_questions->bindValue(':id', $_GET['id']);
    $stmt_delete_questions->execute();

    // Supprimer le quiz
    $stmt_delete_quiz = $dbh->prepare("DELETE FROM QUIZZ WHERE id_QUIZZ = :id");
    $stmt_delete_quiz->bindValue(':id', $_GET['id']);
    $stmt_delete_quiz->execute();

    $dbh->commit();

    header('Location: https://schoolpea.com/BackOffice/Quizzs/index.php?success=1');
    exit();
} catch (PDOException $e) {
    $dbh->rollBack();
    header('Location: https://schoolpea.com/BackOffice/Quizzs?error=1');
    exit();
}
?>
