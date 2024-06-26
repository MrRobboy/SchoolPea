<?php
require_once('db.php');

$sql = "SELECT * FROM COURS";
$result = $dbh->query($sql);
$courses = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Explorer les Cours</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Explorer les Cours</h1>
    </header>
    <main>
        <input type="text" id="search" placeholder="Rechercher des cours..." onkeyup="searchCourses()">
        <div class="courses" id="course_list">
            <?php if (!empty($courses)) : ?>
                <?php foreach ($courses as $course) : ?>
                    <div class="course_item">
                        <h3><?php echo htmlspecialchars($course['nom']); ?></h3>
                        <img src="<?php echo htmlspecialchars($course['path_image_pres']); ?>" alt="Image de présentation">
                        <a href="voirCours.php?id_cours=<?php echo htmlspecialchars($course['id_COURS']); ?>">Voir le cours</a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun cours disponible.</p>
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
    </script>
</body>
</html>
