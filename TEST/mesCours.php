<?php
session_start();
include 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user_id'];

// Récupérer les cours suivis par l'utilisateur
$sql = "SELECT C.* FROM COURS C
        JOIN LIKES_COURS L ON C.id_COURS = L.id_cours
        WHERE L.id_user = :id_user";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_user', $id_user);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Cours Suivis</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Mes Cours Suivis</h1>
        <a href="logout.php">Déconnexion</a> <!-- lien pour la déconnexion -->
    </header>
    <main>
        <input type="text" id="search" placeholder="Rechercher des cours..." onkeyup="searchCourses()">
        <div class="courses" id="course_list">
            <?php if (!empty($courses)) : ?>
                <?php foreach ($courses as $course) : ?>
                    <div class="course_item">
                        <h3><?php echo htmlspecialchars($course['nom']); ?></h3>
                        <?php if (!empty($course['path_image_pres']) && file_exists($course['path_image_pres'])): ?>
                            <img src="<?php echo htmlspecialchars($course['path_image_pres']); ?>" alt="Image de présentation">
                        <?php else: ?>
                            <img src="default-image.jpg" alt="Image par défaut">
                        <?php endif; ?>
                        <a href="voirCours.php?id_cours=<?php echo htmlspecialchars($course['id_COURS']); ?>">Voir le cours</a>
                        <button onclick="unfollowCourse(<?php echo $course['id_COURS']; ?>)">Ne plus suivre</button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun cours suivi.</p>
            <?php endif; ?>
        </div>
    </main>
    <script>
        function searchCourses() {
            let input = document.getElementById('search').value.toLowerCase();
            let courses = document.getElementsByClassName('course_item');
            for (let i = 0; i < courses.length; i++) {
                let courseName = courses[i].getElementsByTagName('h3')[0].textContent.toLowerCase();
                if (courseName.includes(input)) {
                    courses[i].style.display = "";
                } else {
                    courses[i].style.display = "none";
                }
            }
        }

        function unfollowCourse(courseId) {
            if (confirm('Êtes-vous sûr de vouloir ne plus suivre ce cours ?')) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'unfollow.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            location.reload();
                        } else {
                            alert('Erreur lors de la suppression du suivi du cours.');
                        }
                    }
                };
                xhr.send('id_cours=' + encodeURIComponent(courseId));
            }
        }
    </script>
</body>
</html>
