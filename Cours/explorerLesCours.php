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
            <?php foreach ($cours as $cour) : ?>
                <div class="cours">
                    <img src="uploads/<?= htmlspecialchars($cour['image']) ?>" alt="<?= htmlspecialchars($cour['nom']) ?>">
                    <h2><a href="cours.php?id=<?= htmlspecialchars($cour['id']) ?>"><?= htmlspecialchars($cour['nom']) ?></a></h2>
                    <p>Niveau : <?= htmlspecialchars($cour['niveau']) ?></p>
                    <p>Prix : <?= $cour['prix'] == 0 ? 'Gratuit' : htmlspecialchars($cour['prix']) . ' €' ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun cours trouvé.</p>
        <?php endif; ?>
    </div>
</body>

</html>