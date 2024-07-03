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

// Si une réponse est soumise
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answers = $_POST['answers'];

    // Valider et enregistrer les réponses
    foreach ($answers as $questionId => $answerIds) {
        if (!empty($answerIds)) {
            foreach ($answerIds as $answerId) {
                $sql = "INSERT INTO RESULTATS_QUIZZ (id_user, id_question, id_quizz, id_choice) VALUES (?, ?, ?, ?)";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([$_SESSION['id_user'], $questionId, $idQuizz, $answerId]);
            }
        }
    }

    // Vérifier s'il y a une prochaine question à afficher
    $nextQuestion = $currentQuestion + 1;

    if ($nextQuestion > count($questions)) {
        // Rediriger vers la page de résultats du quiz
        header("Location: resultatQuizz.php?id_quizz=$idQuizz");
        exit();
    } else {
        // Rediriger vers la prochaine question
        header("Location: participerQuizz.php?id_quizz=$idQuizz&question=$nextQuestion");
        exit();
    }
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
        function showQuestion() {
            var currentQuestion = <?php echo $currentQuestion; ?>;
            var totalQuestions = <?php echo count($questions); ?>;
            var form = document.getElementById('quiz-form');

            // Afficher la question actuelle
            var questionHeader = document.getElementById('question-header');
            questionHeader.innerText = "Question " + currentQuestion + ":";

            // Afficher le texte de la question
            var questionText = document.getElementById('question-text');
            questionText.innerText = "<?php echo htmlspecialchars($currentQuestionData['question_text']); ?>";

            // Afficher les choix de réponse
            var choicesContainer = document.getElementById('choices-container');
            choicesContainer.innerHTML = ''; // Effacer les anciens choix

            <?php foreach ($choices as $choice) : ?>
                var choiceDiv = document.createElement('div');
                var choiceInput = document.createElement('input');
                choiceInput.type = 'checkbox';
                choiceInput.name = 'answers[<?php echo $currentQuestionData['id_question']; ?>][]';
                choiceInput.value = '<?php echo $choice['id_CHOIX']; ?>';
                choiceInput.id = 'choice-<?php echo $choice['id_CHOIX']; ?>';

                var choiceLabel = document.createElement('label');
                choiceLabel.setAttribute('for', 'choice-<?php echo $choice['id_CHOIX']; ?>');
                choiceLabel.innerText = '<?php echo htmlspecialchars($choice['choix_text']); ?>';

                choiceDiv.appendChild(choiceInput);
                choiceDiv.appendChild(choiceLabel);
                choicesContainer.appendChild(choiceDiv);
            <?php endforeach; ?>
        }

        // Appeler showQuestion() lors du chargement initial
        window.onload = function() {
            showQuestion();
        };
    </script>
</head>
<body>
    <div class="container">
        <h2>Quiz: <?php echo htmlspecialchars($quiz['nom']); ?></h2>
        <form action="participerQuizz.php?id_quizz=<?php echo $idQuizz; ?>&question=<?php echo $currentQuestion; ?>" method="post" id="quiz-form">
            <h3 id="question-header">Question <?php echo $currentQuestion; ?>:</h3>
            <p id="question-text"></p>

            <div id="choices-container">
                <!-- Les choix de réponse seront ajoutés ici par JavaScript -->
            </div>

            <?php if ($currentQuestion < count($questions)) : ?>
                <button type="button" onclick="showQuestion()">Suivant</button>
            <?php else : ?>
                <button type="submit">J'ai Tout Fini</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
