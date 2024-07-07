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
    // Supprime les réponses associées aux questions du quiz
    $stmt_delete_responses = $dbh->prepare("DELETE FROM RESULTATS_QUIZZ WHERE id_question IN (SELECT id_question FROM QUESTIONS WHERE id_quizz = :id)");
    $stmt_delete_responses->bindValue(':id', $_GET['id']);
    $stmt_delete_responses->execute();

    // Supprime les choix associés aux questions du quiz
    $stmt_delete_choices = $dbh->prepare("DELETE FROM CHOIX WHERE id_question IN (SELECT id_question FROM QUESTIONS WHERE id_quizz = :id)");
    $stmt_delete_choices->bindValue(':id', $_GET['id']);
    $stmt_delete_choices->execute();

    // Supprimer les questions du quiz
    $stmt_delete_questions = $dbh->prepare("DELETE FROM QUESTIONS WHERE id_quizz = :id");
    $stmt_delete_questions->bindValue(':id', $_GET['id']);
    $stmt_delete_questions->execute();

    // pui supprimer le quiz lui-même
    $stmt_delete_quiz = $dbh->prepare("DELETE FROM QUIZZ WHERE id_QUIZZ = :id");
    $stmt_delete_quiz->bindValue(':id', $_GET['id']);
    $stmt_delete_quiz->execute();

    $dbh->commit();

    header('Location: https://schoolpea.com/BackOffice/Quizz/index.php?success=1');
    exit();
} catch (PDOException $e) {
    $dbh->rollBack();
    header('Location: https://schoolpea.com/BackOffice/Quizz/index.php?error=1');
    exit();
}
?>
