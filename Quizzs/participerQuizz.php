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

// Si une réponse est soumise
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['answers'][$currentQuestionData['id_question']])) {
        echo "Veuillez sélectionner au moins une réponse.";
        exit();
    }

    $answerIds = $_POST['answers'][$currentQuestionData['id_question']];

    // Valider et enregistrer les réponses
    foreach ($answerIds as $answerId) {
        $sql = "INSERT INTO RESULTATS_QUIZZ (id_user, id_question, id_quizz, id_choice) VALUES (?, ?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$_SESSION['id_user'], $currentQuestionData['id_question'], $idQuizz, $answerId]);
    }

    // Déterminer la prochaine question à afficher
    $nextQuestion = $currentQuestion + 1;

    if ($nextQuestion > count($questions)) {
        // Rediriger vers la page de résultats du quiz
        header("Location: resultatQuizz.php?id_quizz=$idQuizz");
    } else {
        // Rediriger vers la prochaine question
        header("Location: participerQuizz.php?id_quizz=$idQuizz&question=$nextQuestion");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participer au Quiz</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            font-family: "Montserrat", sans-serif;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        h3 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #555;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 15px;
            line-height: 1.8;
        }

        #choices-container {
            text-align: left;
            margin-bottom: 20px;
        }

        #choices-container div {
            margin-bottom: 10px;
        }

        #choices-container label {
            margin-left: 10px;
        }

        button {
            background-color: #5c6bc0;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 20px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #3f51b5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Quiz: <?php echo htmlspecialchars($quiz['nom']); ?></h2>
        <form action="participerQuizz.php?id_quizz=<?php echo $idQuizz; ?>&question=<?php echo $currentQuestion; ?>" method="post">
            <h3>Question <?php echo $currentQuestion; ?>:</h3>
            <p><?php echo htmlspecialchars($currentQuestionData['question_text']); ?></p>

            <div id="choices-container">
                <?php if (!empty($choices)) : ?>
                    <?php foreach ($choices as $choice) : ?>
                        <div>
                            <input type="checkbox" name="answers[<?php echo $currentQuestionData['id_question']; ?>][]" value="<?php echo $choice['id_CHOIX']; ?>" id="choice-<?php echo $choice['id_CHOIX']; ?>">
                            <label for="choice-<?php echo $choice['id_CHOIX']; ?>"><?php echo htmlspecialchars($choice['choix_text']); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucun choix trouvé pour cette question.</p>
                <?php endif; ?>
            </div>

            <button type="submit">Suivant</button>
        </form>
    </div>
</body>
</html>
