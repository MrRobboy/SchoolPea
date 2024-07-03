<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION['id_user'])) {
    header('Location: https://schoolpea.com/Quizzs/login.php');
    exit();
}

// Vérifier s'il y a un ID de quiz passé en paramètre GET
if (!isset($_GET['id_quizz'])) {
    echo "ID de quiz non spécifié.";
    exit();
}

$idQuizz = $_GET['id_quizz'];

// Récupérer les informations sur le quiz
require_once('common.php');
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

// Si une réponse est soumise
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answers = $_POST['answers'];

    // Valider et enregistrer les réponses
    foreach ($answers as $questionId => $answer) {
        if (!empty($answer)) {
            $sql = "INSERT INTO REPONSES_QUIZZ (id_user, id_question, id_quizz, id_choice) VALUES (?, ?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$_SESSION['id_user'], $questionId, $idQuizz, $answer]);
        }
    }

    // Rediriger vers la prochaine question ou vers le résultat si c'est la dernière question
    $nextQuestion = $_POST['next_question'] ?? null;
    if (!empty($nextQuestion)) {
        header("Location: participerQuizz.php?id_quizz=$idQuizz&question=$nextQuestion");
    } else {
        // Rediriger vers la page de résultats
        header("Location: resultatQuizz.php?id_quizz=$idQuizz");
    }
    exit();
}

// Vérifier si une question spécifique est demandée
$currentQuestion = isset($_GET['question']) ? (int)$_GET['question'] : 1;
$totalQuestions = count($questions);

// Récupérer la question actuelle
$currentQuestionData = $questions[$currentQuestion - 1];

// Récupérer les choix de la question
$sql = "SELECT * FROM CHOIX WHERE id_question = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$currentQuestionData['id_question']]);
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            var radios = form.elements['answers'];
            var answered = false;

            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    answered = true;
                    break;
                }
            }

            if (!answered) {
                alert('Veuillez sélectionner une réponse.');
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
            <input type="hidden" name="next_question" value="<?php echo $currentQuestion % $totalQuestions + 1; ?>">
            
            <?php foreach ($choices as $choice) : ?>
                <div>
                    <input type="radio" name="answers[<?php echo $currentQuestionData['id_question']; ?>]" value="<?php echo $choice['id_CHOIX']; ?>" id="choice-<?php echo $choice['id_CHOIX']; ?>">
                    <label for="choice-<?php echo $choice['id_CHOIX']; ?>"><?php echo htmlspecialchars($choice['choix_text']); ?></label>
                </div>
            <?php endforeach; ?>

            <button type="submit">Valider</button>
        </form>
    </div>
</body>
</html>
