<?php
session_start();

$path = $_SERVER['DOCUMENT_ROOT'];
if (isset($_SESSION['mail_valide'])) {
    $path .= '/headerL.php';
} else {
    header('Location: https://schoolpea.com/Connexion');
}
include($path);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
require($path);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id_quizz']) || !is_numeric($_GET['id_quizz'])) {
    echo "ID de quiz non spécifié ou non valide.";
    exit();
}

$idQuizz = (int)$_GET['id_quizz'];

$sql = "SELECT * FROM QUIZZ WHERE id_QUIZZ = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    echo "Quiz non trouvé.";
    exit();
}
$sql = "SELECT * FROM QUESTIONS WHERE id_quizz = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($questions)) {
    echo "Aucune question trouvée pour ce quiz.";
    exit();
}

$currentQuestion = isset($_GET['question']) ? (int)$_GET['question'] : 1;

if ($currentQuestion < 1 || $currentQuestion > count($questions)) {
    echo "Numéro de question invalide.";
    exit();
}

$currentQuestionData = $questions[$currentQuestion - 1];

$sql = "SELECT * FROM CHOIX WHERE id_question = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$currentQuestionData['id_question']]);
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['answers'][$currentQuestionData['id_question']])) {
        echo "Veuillez sélectionner au moins une réponse.";
        exit();
    }

    $answerIds = $_POST['answers'][$currentQuestionData['id_question']];

    foreach ($answerIds as $answerId) {
        $sql = "INSERT INTO RESULTATS_QUIZZ (id_user, id_question, id_quizz, id_choice) VALUES (?, ?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$_SESSION['id_user'], $currentQuestionData['id_question'], $idQuizz, $answerId]);
    }

    $nextQuestion = $currentQuestion + 1;

    if ($nextQuestion > count($questions)) {
        header("Location: resultatQuizz.php?id_quizz=$idQuizz");
    } else {
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
        /* style.css */

        :root {
            --bg-color-light: #ffffff;
            --text-color-light: #333333;
            --accent-color-light: #5c6bc0;
            --bg-color-dark: #333333;
            --text-color-dark: #ffffff;
            --accent-color-dark: #3f51b5;
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

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: var(--bg-color);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: background-color 0.3s;
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        h3 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: var(--text-color);
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 15px;
            line-height: 1.8;
            color: var(--text-color);
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
            color: var(--text-color);
        }

        button {
            background-color: var(--accent-color);
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