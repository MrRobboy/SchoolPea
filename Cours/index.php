<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
require($path);

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
    <?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    if (isset($_SESSION['mail_valide'])) {
        $path .= '/headerL.php';
    } else {
        header('Location: https://schoolpea.com/Connexion');
    }
    include($path);
    ?>

    <span class="trait" id="SchoolPea"></span>

    <div id="div1">
        <h1>Explorer les Cours</h1>
        <input type="text" id="search" placeholder="Rechercher des cours..." onkeyup="searchCourses()">
        <div class="courses" id="course_list">
            <?php if (!empty($courses)) : ?>
                <?php foreach ($courses as $course) : ?>
                    <div class="course_item">
                        <h3><?php echo htmlspecialchars($course['nom']); ?></h3>
                        <?php if (!empty($course['path_image_pres']) && file_exists($course['path_image_pres'])) : ?>
                            <img src="<?php echo htmlspecialchars($course['path_image_pres']); ?>" alt="Image de présentation">
                        <?php else : ?>
                            <img src="default-image.jpg" alt="Image par défaut">
                        <?php endif; ?>
                        <a href="voirCours.php?id_cours=<?php echo htmlspecialchars($course['id_COURS']); ?>">Voir le cours</a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun cours disponible.</p>
            <?php endif; ?>
        </div>
    </div>
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