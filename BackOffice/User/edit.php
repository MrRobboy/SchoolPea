<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$id = $_GET['id'];
$user = getById('users', $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];

    if (update('users', $id, ['role' => $role])) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors de la modification de l\'utilisateur';
    }
}
?>

<div class="container">
    <h1>Modifier l'Utilisateur</h1>
    <form method="post">
        <label>Email:</label>
        <input type="email" value="<?= $user['email'] ?>" disabled>
        <label>Rôle:</label>
        <select name="role">
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
        </select>
        <button type="submit">Modifier</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
