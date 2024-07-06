<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
require($path);

$sql = "SELECT * FROM QUIZZ";
$result = $dbh->query($sql);
$quizzes = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Explorer les Quizz</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <span class="trait" id="SchoolPea"></span>

    <div id="div1">
        <h1>Explorer les Quizz</h1>
        <input type="text" id="search" placeholder="Rechercher des quizz..." onkeyup="searchQuizzes()">
        <div class="quizzes" id="quiz_list">
            <?php if (!empty($quizzes)) : ?>
                <?php foreach ($quizzes as $quiz) : ?>
                    <div class="quiz">
                        <h3><?php echo htmlspecialchars($quiz['nom']); ?></h3>
                        <?php if (!empty($quiz['path_img_pres'])) : ?>
                            <img src="<?php echo htmlspecialchars($quiz['path_img_pres']); ?>" class="img_pres" alt="Image de présentation">
                        <?php else : ?>
                            <img src="default-image.jpg" alt="Image par défaut">
                        <?php endif; ?>
                        <a href="participerQuizz.php?id_quizz=<?php echo htmlspecialchars($quiz['id_QUIZZ']); ?>" style="text-decoration: none;">Voir le quizz</a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun quizz disponible.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function searchQuizzes() {
            let input = document.getElementById('search').value.toLowerCase();
            let quizzes = document.getElementsByClassName('quiz');
            for (let i = 0; i < quizzes.length; i++) {
                let quizName = quizzes[i].getElementsByTagName('h3')[0].textContent.toLowerCase();
                if (quizName.includes(input)) {
                    quizzes[i].style.display = "";
                } else {
                    quizzes[i].style.display = "none";
                }
            }
        }
    </script>
</body>

</html>
