<?php
session_start();

// Inclure le fichier de connexion à la base de données et les fonctions communes
include 'common.php';

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION['mail_valide'])) {
    header('Location: https://schoolpea.com/Connexion');
    exit();
}

// Vérifier si l'ID du quiz est passé en paramètre GET
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

// Vérifier s'il y a des questions à afficher
if (empty($questions)) {
    echo "Aucune question trouvée pour ce quiz.";
    exit();
}

// Vérifier si une réponse a été soumise pour la question précédente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentQuestion = $_POST['current_question'] ?? 1;
    $answer = $_POST['answer'] ?? null;

    // Valider et enregistrer la réponse si une réponse a été donnée
    if (!empty($answer)) {
        $sql = "INSERT INTO REPONSES_QUIZZ (id_user, id_question, id_quizz, id_choice) VALUES (?, ?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$_SESSION['id_user'], $questions[$currentQuestion - 1]['id_question'], $idQuizz, $answer]);
    }

    // Rediriger vers la prochaine question ou vers le résultat si c'est la dernière question
    $nextQuestion = $currentQuestion + 1;
    if ($nextQuestion <= count($questions)) {
        header("Location: participerQuizz.php?id_quizz=$idQuizz&question=$nextQuestion");
    } else {
        header("Location: resultatQuizz.php?id_quizz=$idQuizz");
    }
    exit();
}

// Vérifier si une question spécifique est demandée
$currentQuestion = isset($_GET['question']) ? (int)$_GET['question'] : 1;

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
</head>
<body>
    <div class="container">
        <h2>Quiz: <?php echo htmlspecialchars($quiz['nom']); ?></h2>
        <form action="participerQuizz.php?id_quizz=<?php echo $idQuizz; ?>" method="post">
            <input type="hidden" name="current_question" value="<?php echo $currentQuestion; ?>">
            <h3>Question <?php echo $currentQuestion; ?></h3>
            <p><?php echo htmlspecialchars($currentQuestionData['question_text']); ?></p>

            <?php foreach ($choices as $choice) : ?>
                <div>
                    <input type="radio" name="answer" value="<?php echo $choice['id_CHOIX']; ?>" id="choice-<?php echo $choice['id_CHOIX']; ?>">
                    <label for="choice-<?php echo $choice['id_CHOIX']; ?>"><?php echo htmlspecialchars($choice['choix_text']); ?></label>
                </div>
            <?php endforeach; ?>

            <button type="submit">Valider</button>
        </form>
    </div>
</body>
</html>
