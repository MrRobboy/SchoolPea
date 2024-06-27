<?php
require_once('db.php');

session_start(); // Start session if not already started

// Assuming you have stored user ID in session
$id_user = $_SESSION['id_user'];

// Fetch liked courses for the current user
$sql = "SELECT c.* FROM COURS c
        INNER JOIN LIKES_COURS lc ON c.id_COURS = lc.id_cours
        WHERE lc.id_user = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$id_user]);
$liked_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cours Aimés</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Cours Aimés</h1>
    </header>
    <main>
        <div class="courses">
            <?php if (!empty($liked_courses)) : ?>
                <?php foreach ($liked_courses as $course) : ?>
                    <div class="course_item">
                        <h3><?php echo htmlspecialchars($course['nom']); ?></h3>
                        <p>Niveau : <?php echo htmlspecialchars($course['niveau']); ?></p>
                        <p>Description : <?php echo htmlspecialchars($course['description']); ?></p>
                        <a href="voirCours.php?id_cours=<?php echo htmlspecialchars($course['id_COURS']); ?>">Voir le cours</a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun cours suivi .</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
