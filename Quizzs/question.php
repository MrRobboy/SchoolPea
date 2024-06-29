// question.php
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_question = $_SESSION['current_question'];
    $answer = $_POST['answer'];

    if ($answer == $_SESSION['questions'][$current_question]['is_correct']) {
        $_SESSION['score']++;
    }

    $_SESSION['current_question']++;

    if ($_SESSION['current_question'] >= count($_SESSION['questions'])) {
        header("Location: results.php");
        exit();
    }
}

$current_question = $_SESSION['current_question'];
$question = $_SESSION['questions'][$current_question];
?>

