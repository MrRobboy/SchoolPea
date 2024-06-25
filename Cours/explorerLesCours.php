<?php
session_start();
require_once 'db.php';

// Gestion de la recherche
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = $db->prepare("SELECT * FROM COURS WHERE nom LIKE ? OR niveau LIKE ?");
    $query->execute(['%' . $search . '%', '%' . $search . '%']);
} else {
    $query = $db->query("SELECT * FROM COURS");
}
$cours = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Explorer les cours</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <h1>Explorer les cours</h1>
    <!-- Formulaire de recherche -->
    <form method="get" action="explorerLesCours.php">
        <input type="text" name="search" placeholder="Rechercher des cours" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Rechercher</button>
    </form>
    <div class="cours">
        <?php if (count($cours) > 0) : ?>
            <?php foreach ($cours as $coursItem) : ?>
                <div class="cours">
                    <?php if (!empty($coursItem['image']) && file_exists('uploads/' . $coursItem['image'])) : ?>
                        <img src="uploads/<?= htmlspecialchars($coursItem['image']) ?>" alt="<?= htmlspecialchars($coursItem['nom']) ?>">
                    <?php else : ?>
                        <img src="placeholder.jpg" alt="Image non disponible">
                    <?php endif; ?>
                    <h2><a href="cours.php?id=<?= htmlspecialchars($coursItem['id']) ?>"><?= htmlspecialchars($coursItem['nom']) ?></a></h2>
                    <p>Niveau : <?= htmlspecialchars($coursItem['niveau']) ?></p>
                    <p>Prix : <?= $coursItem['prix'] == 0 ? 'Gratuit' : htmlspecialchars($coursItem['prix']) . ' €' ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun cours trouvé.</p>
        <?php endif; ?>
    </div>
</body>

</html>