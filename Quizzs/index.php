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
    <style>


:root {
    --bg-color-light: #ffffff;
    --text-color-light: #333333;
    --accent-color-light: #512da8;
    --bg-color-dark: #333333;
    --text-color-dark: #ffffff;
    --accent-color-dark: #5c6bc0;
}

[data-theme="light"] {
    --bg-color: var(--bg-color-light);
    --text-color: var(--text-color-light);
    --accent-color: var(--accent-color-light);
}

[data-theme="dark"] {
    --bg-color: var(--bg-color-dark);
    --text-color: var(--text-color-dark);
    --accent-color: var(--accent-color-dark);
}

body {
    background-color: var(--bg-color);
    background: linear-gradient(to right, #e2e2e2, var(--bg-color));
    color: var(--text-color);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
    font-family: "Montserrat", sans-serif;
    margin: 0;
    transition: background-color 0.3s, color 0.3s;
}

.trait {
    padding: 0.2em 5em;
    border-radius: 3em;
    background-color: transparent;
    margin-bottom: 10em;
}

#div1 {
    padding: 20px;
    margin: 4em auto;
}

h1 {
    text-align: center;
}

#search {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.quizzes {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px auto 0;
}

.quiz {
    background-color: var(--bg-color);
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 15px;
    text-align: center;
    align-items: center;
    justify-content: center;
    display: flex;
    flex-direction: column;
}

.quiz img {
    max-width: 150px;
    height: auto;
    border-radius: 5px;
}

.quiz a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background-color: var(--accent-color);
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.quiz a:hover {
    background-color: #3f51b5;
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
