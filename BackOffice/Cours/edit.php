<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$id = $_GET['id'];
$question = getById('captcha_questions', $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questionText = $_POST['question'];
    $answer = $_POST['answer'];

    if (update('captcha_questions', $id, ['question' => $questionText, 'answer' => $answer])) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors de la modification de la question';
    }
}
?>

<div class="container">
    <h1>Modifier la Question CAPTCHA</h1>
    <form method="post">
        <label>Question:</label>
        <input type="text" name="question" value="<?= $question['question'] ?>" required>
        <label>Réponse:</label>
        <input type="text" name="answer" value="<?= $question['answer'] ?>" required>
        <button type="submit">Modifier</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
