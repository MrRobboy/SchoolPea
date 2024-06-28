<?php
require_once('db.php');

session_start(); // Start session if not already started

// Assuming you have stored user ID in session
if (!isset($_SESSION['id_user'])) {
    echo "Vous devez être connecté pour voir cette page.";
    exit();
}

$id_user = $_SESSION['id_user'];

// Handle course unfollow action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'unfollow' && isset($_POST['id_cours'])) {
    $id_cours = $_POST['id_cours'];

    // Delete entry from LIKES_COURS table
    $sql_unlike = "DELETE FROM LIKES_COURS WHERE id_user = ? AND id_cours = ?";
    $stmt_unlike = $dbh->prepare($sql_unlike);

    if ($stmt_unlike->execute([$id_user, $id_cours])) {
        $message = "Cours supprimé des cours aimés.";
    } else {
        $message = "Erreur lors de la suppression du cours.";
    }
}

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
        <?php if (isset($message)) : ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <div class="courses">
            <?php if (!empty($liked_courses)) : ?>
                <?php foreach ($liked_courses as $course) : ?>
                    <div class="course_item">
                        <h3><?php echo htmlspecialchars($course['nom']); ?></h3>
                        <p>Niveau : <?php echo htmlspecialchars($course['niveau']); ?></p>
                        <p>Description : <?php echo htmlspecialchars($course['description']); ?></p>
                        <a href="voirCours.php?id_cours=<?php echo htmlspecialchars($course['id_COURS']); ?>">Voir le cours</a>
                        <form action="mesCours.php" method="POST">
                            <input type="hidden" name="action" value="unfollow">
                            <input type="hidden" name="id_cours" value="<?php echo htmlspecialchars($course['id_COURS']); ?>">
                            <button type="submit" class="button">Ne plus suivre</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun cours suivi.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
