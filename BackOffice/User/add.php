<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if (create('users', ['email' => $email, 'password' => $password, 'role' => $role])) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors de l\'ajout de l\'utilisateur';
    }
}
?>

<div class="container">
    <h1>Ajouter un Utilisateur</h1>
    <form method="post">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Mot de passe:</label>
        <input type="password" name="password" required>
        <label>Rôle:</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        <button type="submit">Ajouter</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
