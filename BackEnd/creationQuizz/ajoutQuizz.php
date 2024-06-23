<?php
// create_quiz.php

// Connexion à la base de données
$host = 'localhost';
$dbname = 'PA';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $nom_quizz = $_POST['nom_quizz'];
        $path_img_pres = $_POST['path_img_pres'];
        $total_questions = $_POST['total_questions'];

        // Insérer le quiz dans la table `quizzes`
        $query = "INSERT INTO QUIZZ (nom, path_img_pres) VALUES (:nom_quizz, :path_img_pres)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom_quizz', $nom_quizz, PDO::PARAM_STR);
        $stmt->bindParam(':path_img_pres', $path_img_pres, PDO::PARAM_STR);
        $stmt->execute();
        $quiz_id = $pdo->lastInsertId();

        // Insérer chaque question avec ses réponses dans la base de données
        for ($i = 1; $i <= $total_questions; $i++) {
            $question_text = $_POST['question_' . $i];
            $choix_text = $_POST['choix_' . $i];
            $correct_choix_text = $_POST['correct_choix_' . $i];

            // Diviser les choix et les réponses correctes en tableaux
            $choix = explode(",", $choix_text);
            $correct_choix = explode(",", $correct_choix_text);

            // Insérer la question dans la table `questions`
            $query = "INSERT INTO QUESTIONS (id_quizz, question_text) VALUES (:quiz_id, :question_text)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
            $stmt->bindParam(':question_text', $question_text, PDO::PARAM_STR);
            $stmt->execute();
            $question_id = $pdo->lastInsertId();

            // Insérer les choix dans la table `choix`
            foreach ($choix as $key => $choix_text) {
                $is_correct = (in_array($key + 1, $correct_choix)) ? 1 : 0; // $key + 1 car les clés commencent à 0
                $query = "INSERT INTO CHOIX (id_question, choix_text, is_correct) VALUES (:question_id, :choix_text, :is_correct)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
                $stmt->bindParam(':choix_text', $choix_text, PDO::PARAM_STR);
                $stmt->bindParam(':is_correct', $is_correct, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        $msg = "Quiz ajouté avec succès";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Quiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Créer un Quiz</h1>
    </header>
    <main>
        <div class="form-preview-wrapper">
            <?php if (isset($msg)): ?>
                <p><?= $msg ?></p>
            <?php endif; ?>
            <div class="preview">
                <h2>Prévisualisation du Quiz</h2>
                <div id="quizPreview">
                    <p v-if="!quiz.nom">Nom du Quiz</p>
                    <h3>{{ quiz.nom }}</h3>
                    <img v-if="quiz.path_img_pres" :src="quiz.path_img_pres" alt="Image de présentation">
                    <p v-else>Image de présentation</p>
                    <div v-for="(question, index) in questions" :key="index">
                        <h4>Question {{ index + 1 }}</h4>
                        <p>{{ question.question_text }}</p>
                        <ul>
                            <li v-for="(choix, idx) in question.choix" :key="idx">
                                {{ choix }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 PHP Quizzer. Tous droits réservés.</p>
    </footer>
</div>
<script src="js/script.js"></script>
</body>
</html>
