// playQuizz.php
<?php
require_once('db.php');

$id_quizz = $_GET['id'];
$sql = "SELECT * FROM QUESTIONS WHERE id_quizz = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id_quizz);
$stmt->execute();
$result = $stmt->get_result();

$questions = array();
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

$stmt->close();
$dbh->close();

session_start();
$_SESSION['questions'] = $questions;
$_SESSION['current_question'] = 0;
$_SESSION['score'] = 0;

header("Location: question.php");
?>
