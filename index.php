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
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<title>Schoolpéa</title>
	<link rel="stylesheet" type="text/css" href="https://schoolpea.com/accueil.css">
</head>

<body>
	<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
	if (isset($_SESSION['mail_valide'])) {
		$path .= '/headerL.php';
	} else {
		$path .= '/headerNL.php';
	}
	include($path);
	?>

	<span class="trait" id="SchoolPea"></span>

	<div id="shadow_search">
		<div id="Search_section">
			<div class="aff">
				<span id="text_search">
					<h1 style="font-weight: bold; font-size: 60px">
						SchoolPéa
					</h1>
					<h6 style="font-weight: 500; font-size: 18px">
						Jouons pour apprendre,<br />
						Gagnons pour réussir !
					</h6>
				</span>
				<img id="logo_aff" src="https://schoolpea.com/Images/SchoolPea.png" alt="Logo" />
			</div>

			<div class="but">
				<a href="https://schoolpea.com/Cours/">
					Trouver un cours
				</a>
				<a href="https://schoolpea.com/Quizzs/">
					Trouver un quizz
				</a>
			</div>

			<div id="barreDeRecherche">
    <input type="text" id="coursenquizz-search" placeholder="Rechercher des cours ou des quizz..." onkeyup="searchCoursesAndQuizzs()">
</div>
</div>
</div>

<span class="trait" id="Explorer_les_cours"></span>

<div id="Cours_section">
    <span style="margin-bottom: -2em;">
        <p id="titre_cours">Nos Cours les plus populaires</p>
    </span>
    <div class="fenetre">
        <div class="courses" id="course_list">
            <?php if (!empty($courses)) : ?>
                <?php foreach ($courses as $course) : ?>
                    <div class="course_item">
                        <h3 style="margin: 0;"><?php echo htmlspecialchars($course['nom']); ?></h3>
                        <?php if (!empty($course['path_image_pres'])) : ?>
                            <img src="<?php echo htmlspecialchars($course['path_image_pres']); ?>" class="img_pres" alt="Image de présentation">
                        <?php else : ?>
                            <img src="default-image.jpg" alt="Image par défaut">
                        <?php endif; ?>
                        <a href="/Cours/voirCours.php?id_cours=<?php echo htmlspecialchars($course['id_COURS']); ?>" class="But_voir">Voir le cours</a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun cours disponible.</p>
            <?php endif; ?>
        </div>
    </div>

    <span>
        <a class="voir_plus" href="https://schoolpea.com/Connexion/">
            Voir plus >
        </a>
    </span>

    <span class="trait" id="2"></span>

    <div id="Quizz_section">
        <span>
            <p id="titre_quizz">Nos Quizzs les plus sollicités !</p>
        </span>
        <div id="div_quizz">
            <div class="fenetre">
                <div class="courses" id="quizz_list">
                    <?php if (!empty($quizzes)) : ?>
                        <?php foreach ($quizzes as $quiz) : ?>
                            <div class="course_item">
                                <h3 style="margin: 0;"><?php echo htmlspecialchars($['nom']); ?></h3>
                                <?php if (!empty($quiz['path_image_pres'])) : ?>
                                    <img src="<?php echo htmlspecialchars($quiz['path_image_pres']); ?>" class="img_pres" alt="Image de présentation">
                                <?php else : ?>
                                    <img src="default-image.jpg" alt="Image par défaut">
                                <?php endif; ?>
                                <a href="/Quizzs/participerQuizz.php?id_quizz=<?php echo htmlspecialchars($quiz['id_QUIZZ']); ?>" class="But_voir">Voir le quizz</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Aucun Quizz disponible.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <span>
            <a class="voir_plus" href="https://schoolpea.com/Connexion/">Voir plus ></a>
        </span>
    </div>

    <span class="trait" id="3"></span>

    <footer>
        <div class="footer">
            <span class="col1">
                <h3>
                    <a href="#SchoolPea" style="color: white; text-decoration: none; font-weight: bolder;">SchoolPéa</a>
                </h3>
            </span>

            <span class="col2">
                <h4>Schoolpéa</h4>
                <a href="index.php">Accueil</a>
                <a href="about.php">A propos</a>
            </span>

            <span class="col3">
                <h4>Contact</h4>
                <a href="mailto:schoolpea@outlook.com">E-mail</a>
                <a href="https://schoolpea.com/EasterEgg/">LinkedIn</a>
            </span>
        </div>
    </footer>

    <script>
        function searchCoursesAndQuizzs() {
            let input = document.getElementById('coursenquizz-search').value.toLowerCase();
            let courseItems = document.querySelectorAll('#course_list .course_item');
            let quizzItems = document.querySelectorAll('#quizz_list .course_item');

            courseItems.forEach(item => {
                let courseName = item.querySelector('h3').textContent.toLowerCase();
                if (courseName.includes(input)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });

            quizzItems.forEach(item => {
                let quizzName = item.querySelector('h3').textContent.toLowerCase();
                if (quizzName.includes(input)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        }
    </script>
</body>


</html>