<?php
require_once('db.php');

// Récupérer la liste des quizz depuis la base de données
$stmt = $dbh->query("SELECT id_quizz, nom, path_img_pres FROM QUIZZ");
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Quizz</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Liste des Quizz</h1>
    </header>
    <main>
        <div class="quizzes">
            <?php if (!empty($quizzes)) : ?>
                <?php foreach ($quizzes as $quiz) : ?>
                    <div class="quiz">
                        <img src="<?php echo htmlspecialchars($quiz['path_img_pres']); ?>" alt="Image de présentation">
                        <h2><?php echo htmlspecialchars($quiz['nom']); ?></h2>
                        <a href="quizz.php?id=<?php echo htmlspecialchars($quiz['id_quizz']); ?>">Démarrer le Quizz</a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun quizz disponible.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
