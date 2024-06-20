<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    if (create('captcha_questions', ['question' => $question, 'answer' => $answer])) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors de l\'ajout de la question';
    }
}
?>

<div class="container">
    <h1>Ajouter une Question CAPTCHA</h1>
    <form method="post">
        <label>Question:</label>
        <input type="text" name="question" required>
        <label>Réponse:</label>
        <input type="text" name="answer" required>
        <button type="submit">Ajouter</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
