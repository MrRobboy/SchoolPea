<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$id = $_GET['id'];
$course = getById('courses', $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (update('courses', $id, ['title' => $title, 'description' => $description])) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors de la modification du cours';
    }
}
?>

<div class="container">
    <h1>Modifier le Cours</h1>
    <form method="post">
        <label>Titre:</label>
        <input type="text" name="title" value="<?= $course['title'] ?>" required>
        <label>Description:</label>
        <textarea name="description" required><?= $course['description'] ?></textarea>
        <button type="submit">Modifier</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
