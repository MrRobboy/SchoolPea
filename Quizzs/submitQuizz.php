<?php
include 'common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizName = $_POST['quiz_name'];
    $quizDescription = $_POST['quiz_description'];

    // Insert into QUIZZ table
    $sql = "INSERT INTO QUIZZ (nom, description) VALUES (:name, :description)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $quizName);
    $stmt->bindParam(':description', $quizDescription);
    $stmt->execute();
    $quizId = $dbh->lastInsertId();

    // Insert questions and choices
    foreach ($_POST['questions'] as $question) {
        $questionText = $question['text'];
        $sql = "INSERT INTO QUESTIONS (id_quizz, question_text) VALUES (:quiz_id, :question_text)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':quiz_id', $quizId);
        $stmt->bindParam(':question_text', $questionText);
        $stmt->execute();
        $questionId = $dbh->lastInsertId();

        foreach ($question['choices'] as $choice) {
            $choiceText = $choice['text'];
            $isCorrect = isset($choice['is_correct']) ? 1 : 0;
            $sql = "INSERT INTO CHOIX (id_question, choix_text, is_correct) VALUES (:question_id, :choice_text, :is_correct)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':question_id', $questionId);
            $stmt->bindParam(':choice_text', $choiceText);
            $stmt->bindParam(':is_correct', $isCorrect);
            $stmt->execute();
        }
    }

    header("Location: quizzSuccess.php");
    exit();
}
?>
