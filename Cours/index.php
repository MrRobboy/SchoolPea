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
    <style>
        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            font-family: "Montserrat", sans-serif;
            margin: 0;
        }

        #div1 {
            width: 80%;
            max-width: 1200px;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        #search {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .courses {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .course_item {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .course_item:hover {
            transform: translateY(-5px);
        }

        .course_item img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .course_item h3 {
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .course_item a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .course_item a:hover {
            background-color: #45a049;
        }
    </style>
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
                        <?php if (!empty($course['path_image_pres'])) : ?>
                            <img src="<?php echo htmlspecialchars($course['path_image_pres']); ?>" class="img_pres" alt="Image de présentation">
                        <?php else : ?>
                            <img src="default-image.jpg" alt="Image par défaut">
                        <?php endif; ?>
                        <a href="voirCours.php?id_cours=<?php echo htmlspecialchars($course['id_COURS']); ?>" style="text-decoration: none;">Voir le cours</a>
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
