<?php
require_once('common.php');

// Vérifier si l'ID du quiz est spécifié dans l'URL
if (!isset($_GET['id_quizz'])) {
    echo "ID de quiz non spécifié.";
    exit();
}

$idQuizz = $_GET['id_quizz'];

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

// Déterminer la question actuelle
$currentQuestion = isset($_GET['question']) ? (int)$_GET['question'] : 1;

// Vérifier si la question actuelle est valide
if ($currentQuestion < 1 || $currentQuestion > count($questions)) {
    echo "Numéro de question invalide.";
    exit();
}

// Récupérer les données de la question actuelle
$currentQuestionData = $questions[$currentQuestion - 1];

// Récupérer les choix de la question actuelle
$sql = "SELECT * FROM CHOIX WHERE id_question = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$currentQuestionData['id_question']]);
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des choix sont trouvés
if (empty($choices)) {
    echo "Aucun choix trouvé pour cette question.";
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
        <form action="participerQuizz.php?id_quizz=<?php echo $idQuizz; ?>&question=<?php echo $currentQuestion; ?>" method="post" id="quiz-form" onsubmit="return validateQuestion()">
            <h3>Question <?php echo $currentQuestion; ?>:</h3>
            <p><?php echo htmlspecialchars($currentQuestionData['question_text']); ?></p>

            <div id="choices-container">
                <?php foreach ($choices as $choice) : ?>
                    <div>
                        <input type="checkbox" name="answers[<?php echo $currentQuestionData['id_question']; ?>][]" value="<?php echo $choice['id_CHOIX']; ?>" id="choice-<?php echo $choice['id_CHOIX']; ?>">
                        <label for="choice-<?php echo $choice['id_CHOIX']; ?>"><?php echo htmlspecialchars($choice['choix_text']); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit">Suivant</button>
        </form>
    </div>
</body>
</html>
