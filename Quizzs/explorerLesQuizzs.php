<?php
// Connexion à la base de données
require_once('db.php');

// Requête SQL pour récupérer les quizzs et compter le nombre de questions pour chaque quizz
$sql = "SELECT q.id_QUIZZ, q.nom, q.path_img_pres, COUNT(que.id_question) as nombre_questions 
        FROM QUIZZ q 
        LEFT JOIN QUESTIONS que ON q.id_QUIZZ = que.id_quizz 
        GROUP BY q.id_QUIZZ, q.nom, q.path_img_pres";
$result = $dbh->query($sql);
$quizzs = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Explorer les Quizzs</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Styles de base pour la présentation des quizzs */
        .quizz_item {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .quizz_item img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .quizz_item h3 {
            margin: 10px 0;
        }
        .quizz_item p {
            margin: 10px 0;
        }
        .quizz_item a button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .quizz_item a button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Explorer les Quizzs</h1>
    </header>
    <main>
        <input type="text" id="search" placeholder="Rechercher des quizzs..." onkeyup="searchQuizzs()">
        <div class="quizzs" id="quizz_list">
            <?php if (!empty($quizzs)) : ?>
                <?php foreach ($quizzs as $quizz) : ?>
                    <div class="quizz_item">
                        <h3><?php echo htmlspecialchars($quizz['nom']); ?></h3>
                        <?php if (!empty($quizz['path_img_pres']) && file_exists($quizz['path_img_pres'])): ?>
                            <img src="<?php echo htmlspecialchars($quizz['path_img_pres']); ?>" alt="Image de présentation">
                        <?php else: ?>
                            <img src="default-image.jpg" alt="Image par défaut">
                        <?php endif; ?>
                        <p>Nombre de questions: <?php echo htmlspecialchars($quizz['nombre_questions']); ?></p>
                        <a href="playQuizz.php?id_quizz=<?php echo htmlspecialchars($quizz['id_QUIZZ']); ?>"><button>Commencer</button></a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun quizz disponible.</p>
            <?php endif; ?>
        </div>
    </main>
    <script>
        function searchQuizzs() {
            let input = document.getElementById('search').value.toLowerCase();
            let quizzs = document.getElementsByClassName('quizz_item');
            for (let i = 0; i < quizzs.length; i++) {
                let quizzName = quizzs[i].getElementsByTagName('h3')[0].textContent.toLowerCase();
                if (quizzName.includes(input)) {
                    quizzs[i].style.display = "";
                } else {
                    quizzs[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
