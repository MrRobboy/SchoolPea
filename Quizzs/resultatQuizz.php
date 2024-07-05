<?php
require_once('common.php');

// Démarrer la session si ce n'est pas déjà fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'ID du quiz est spécifié dans l'URL et est un entier valide
if (!isset($_GET['id_quizz']) || !is_numeric($_GET['id_quizz'])) {
    echo "ID de quiz non spécifié ou non valide.";
    exit();
}

$idQuizz = (int)$_GET['id_quizz'];

// Récupérer les informations sur le quiz
$sql = "SELECT * FROM QUIZZ WHERE id_QUIZZ = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    echo "Quiz non trouvé.";
    exit();
}

// Récupérer les questions du quiz
$sql = "SELECT * FROM QUESTIONS WHERE id_quizz = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier s'il y a des questions
if (empty($questions)) {
    echo "Aucune question trouvée pour ce quiz.";
    exit();
}

// Calculer le nombre total de questions dans le quiz
$totalQuestions = count($questions);

// Si une réponse est soumise
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialiser le compteur de bonnes réponses
    $bonnesReponses = 0;

    // Valider et enregistrer les réponses
    foreach ($questions as $question) {
        $questionId = $question['id_question'];
        if (isset($_POST['answers'][$questionId])) {
            $answerIds = $_POST['answers'][$questionId];
            foreach ($answerIds as $answerId) {
                // Vérifier si cette réponse est correcte
                $sql = "SELECT is_correct FROM CHOIX WHERE id_CHOIX = ?";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([$answerId]);
                $choice = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($choice && $choice['is_correct'] == 1) {
                    $bonnesReponses++;
                    break; // Sortir de la boucle dès qu'une réponse correcte est trouvée
                }
            }
        }
    }

    // Calculer le pourcentage de bonnes réponses
    $pourcentageBonnesReponses = ($bonnesReponses / $totalQuestions) * 100;

    // Rediriger vers la page de résultats du quiz avec les informations mises à jour
    header("Location: resultatQuizz.php?id_quizz=$idQuizz&bonnes_reponses=$bonnesReponses&total_questions=$totalQuestions&pourcentage_bonnes_reponses=$pourcentageBonnesReponses");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participer au Quiz</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateQuestion() {
            var form = document.getElementById('quiz-form');
            var checkboxes = form.elements['answers[]'];
            var answered = false;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    answered = true;
                    break;
                }
            }

            if (!answered) {
                alert('Veuillez sélectionner au moins une réponse.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Quiz: <?php echo htmlspecialchars($quiz['nom']); ?></h2>
        <form action="participerQuizz.php?id_quizz=<?php echo $idQuizz; ?>" method="post" id="quiz-form" onsubmit="return validateQuestion()">
            <?php foreach ($questions as $question) : ?>
                <h3>Question <?php echo $question['id_question']; ?>:</h3>
                <p><?php echo htmlspecialchars($question['question_text']); ?></p>

                <?php
                // Récupérer les choix pour cette question
                $sql = "SELECT * FROM CHOIX WHERE id_question = ?";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([$question['id_question']]);
                $choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div id="choices-container">
                    <?php foreach ($choices as $choice) : ?>
                        <div>
                            <input type="checkbox" name="answers[<?php echo $question['id_question']; ?>][]" value="<?php echo $choice['id_CHOIX']; ?>" id="choice-<?php echo $choice['id_CHOIX']; ?>">
                            <label for="choice-<?php echo $choice['id_CHOIX']; ?>"><?php echo htmlspecialchars($choice['choix_text']); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit">Soumettre</button>
        </form>
    </div>
</body>
</html>
