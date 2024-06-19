<?php
include 'includes/auth.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $stmt = $pdo->prepare('INSERT INTO content (title, body) VALUES (?, ?)');
                $stmt->execute([$_POST['title'], $_POST['body']]);
                break;
            case 'update':
                $stmt = $pdo->prepare('UPDATE content SET title = ?, body = ? WHERE id = ?');
                $stmt->execute([$_POST['title'], $_POST['body'], $_POST['id']]);
                break;
            case 'delete':
                $stmt = $pdo->prepare('DELETE FROM content WHERE id = ?');
                $stmt->execute([$_POST['id']]);
                break;
        }
    }
}

$contentItems = $pdo->query('SELECT * FROM content')->fetchAll();
include 'templates/header.php';
?>

<h1>Gestion du Contenu</h1>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Contenu</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contentItems as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['title']) ?></td>
            <td><?= htmlspecialchars($item['body']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="title" value="<?= $item['title'] ?>">
                    <input type="hidden" name="body" value="<?= $item['body'] ?>">
                    <button type="submit" name="action" value="edit">Modifier</button>
                    <button type="submit" name="action" value="delete">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Ajouter du Contenu</h2>
<form method="POST">
    <label>Titre: <input type="text" name="title" required></label>
    <label>Contenu: <textarea name="body" required></textarea></label>
    <button type="submit" name="action" value="create">Ajouter</button>
</form>

<?php include 'templates/footer.php'; ?>
