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

        // Vérifier et télécharger l'image de présentation
        $upload_dir = 'uploads/'; // Répertoire où stocker les images
        $path_img_pres = $_FILES['path_img_pres'];

        // Vérifier si un fichier a été téléchargé
        if ($path_img_pres['error'] === UPLOAD_ERR_OK) {
            $file_name = basename($path_img_pres['name']);
            $upload_path = $upload_dir . $file_name;

            // Déplacer le fichier téléchargé vers le répertoire d'uploads
            if (move_uploaded_file($path_img_pres['tmp_name'], $upload_path)) {
                // Image téléchargée avec succès, utiliser $upload_path dans votre base de données
                $path_img_pres = $upload_path;
            } else {
                die("Erreur lors du téléchargement de l'image.");
            }
        } else {
            die("Erreur: " . $path_img_pres['error']);
        }

        // Insérer le quiz dans la table `quizzes`
        $query = "INSERT INTO quizzes (nom, path_img_pres) VALUES (:nom_quizz, :path_img_pres)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom_quizz', $nom_quizz, PDO::PARAM_STR);
        $stmt->bindParam(':path_img_pres', $path_img_pres, PDO::PARAM_STR);
        $stmt->execute();
        $quiz_id = $pdo->lastInsertId();

        // Insérer chaque question avec ses réponses dans la base de données
        for ($i = 1; $i <= $total_questions; $i++) {
            $question_text = $_POST['question_' . $i];
            $choices_text = $_POST['choices_' . $i];
            $correct_choices_text = $_POST['correct_choices_' . $i];

            // Diviser les choix et les réponses correctes en tableaux
            $choices = explode(",", $choices_text);
            $correct_choices = explode(",", $correct_choices_text);

            // Insérer la question dans la table `questions`
            $query = "INSERT INTO questions (id_quizz, question_text) VALUES (:quiz_id, :question_text)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
            $stmt->bindParam(':question_text', $question_text, PDO::PARAM_STR);
            $stmt->execute();
            $question_id = $pdo->lastInsertId();

            // Insérer les choix dans la table `choices`
            foreach ($choices as $key => $choice_text) {
                $is_correct = (in_array($key + 1, $correct_choices)) ? 1 : 0; // $key + 1 car les clés commencent à 0
                $query = "INSERT INTO choices (id_question, choice_text, is_correct) VALUES (:question_id, :choice_text, :is_correct)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
                $stmt->bindParam(':choice_text', $choice_text, PDO::PARAM_STR);
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
    <title>Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Confirmation</h1>
    </header>
    <main>
        <?php if (isset($msg)): ?>
            <p><?= $msg ?></p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 PHP Quizzer. Tous droits réservés.</p>
    </footer>
</div>
</body>
</html>