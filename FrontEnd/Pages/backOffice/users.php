<?php
include 'includes/auth.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
                $stmt->execute([$_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['role']]);
                break;
            case 'update':
                $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?');
                $stmt->execute([$_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['role'], $_POST['id']]);
                break;
            case 'delete':
                $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
                $stmt->execute([$_POST['id']]);
                break;
        }
    }
}

$users = $pdo->query('SELECT * FROM users')->fetchAll();
include 'templates/header.php';
?>

<h1>Gestion des Utilisateurs</h1>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <input type="hidden" name="name" value="<?= $user['name'] ?>">
                    <input type="hidden" name="email" value="<?= $user['email'] ?>">
                    <input type="hidden" name="password" value="<?= $user['password'] ?>">
                    <input type="hidden" name="role" value="<?= $user['role'] ?>">
                    <button type="submit" name="action" value="edit">Modifier</button>
                    <button type="submit" name="action" value="delete">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Ajouter un Utilisateur</h2>
<form method="POST">
    <label>Nom: <input type="text" name="name" required></label>
    <label>Email: <input type="email" name="email" required></label>
    <label>Mot de passe: <input type="password" name="password" required></label>
    <label>Rôle:
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="user">Utilisateur</option>
        </select>
    </label>
    <button type="submit" name="action" value="create">Ajouter</button>
</form>

<?php include 'templates/footer.php'; ?>
