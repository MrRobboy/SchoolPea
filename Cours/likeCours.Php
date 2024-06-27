<?php
require_once('db.php');

session_start(); // Start session if not already started

// Si l'utilisateur a cliqué sur le bouton de like
if (isset($_GET['id_cours'])) {
    $id_cours = $_GET['id_cours'];
    $id_user = $_SESSION['id_user']; // Assuming you have stored user ID in session

    // Insertion dans la table LIKES_COURS
    $sql = "INSERT INTO LIKES_COURS (id_user, id_cours) VALUES (?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id_user, $id_cours]);

    // Redirection vers voirCours.php après avoir aimé
    header("Location: voirCours.php?id_cours=$id_cours");
    exit();
}

// Récupération des cours aimés pour l'utilisateur actuel
$id_user = $_SESSION['id_user'];

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
        <!-- Affichage des cours aimés -->
        <div class="courses">
            <?php if (!empty($liked_courses)) : ?>
                <?php foreach ($liked_courses as $course) : ?>
                    <div class="course_item">
                        <h3><?php echo htmlspecialchars($course['nom']); ?></h3>
                        <p>Niveau : <?php echo htmlspecialchars($course['niveau']); ?></p>
                        <p>Description : <?php echo htmlspecialchars($course['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun cours aimé.</p>
            <?php endif; ?>
        </div>

        <!-- Formulaire pour liker un cours -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <label for="id_cours">ID du cours à liker :</label>
            <input type="text" id="id_cours" name="id_cours">
            <button type="submit">Liker ce cours</button>
        </form>
    </main>
</body>
</html>
