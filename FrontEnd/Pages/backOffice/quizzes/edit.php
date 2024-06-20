<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$id = $_GET['id'];
$quizz = getById('quizzes', $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (update('quizzes', $id, ['title' => $title, 'description' => $description])) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors de la modification du quizz';
    }
}
?>

<div class="container">
    <h1>Modifier le Quizz</h1>
    <form method="post">
        <label>Titre:</label>
        <input type="text" name="title" value="<?= $quizz['title'] ?>" required>
        <label>Description:</label>
        <textarea name="description" required><?= $quizz['description'] ?></textarea>
        <button type="submit">Modifier</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
