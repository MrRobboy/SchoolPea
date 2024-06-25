<?php
session_start();
require_once 'db.php';

$user_id = $_SESSION['user_id'];
$query = $db->prepare("SELECT COURS.* FROM COURS JOIN likes ON COURS.id = likes.id_cours WHERE likes.id_user = ?");
$query->execute([$user_id]);
$cours = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes cours likés</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Mes cours likés</h1>
    <div class="cours">
        <?php foreach ($cours as $cours): ?>
            <div class="cours">
                <img src="uploads/<?= $cours['image'] ?>" alt="<?= $cours['name'] ?>">
                <h2><a href="cours.php?id=<?= $cours['id'] ?>"><?= $cours['name'] ?></a></h2>
                <p>Niveau : <?= $cours['level'] ?></p>
                <p>Prix : <?= $cours['price'] == 0 ? 'Gratuit' : $cours['price'] . ' €' ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
