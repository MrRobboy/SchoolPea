<?php
require_once('common.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Stocker l'URL actuelle
    header("Location: login.php");
    exit();
}

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

// Compter le nombre total de questions
$totalQuestions = count($questions);

// Vérifier si l'utilisateur est connecté et récupérer son ID utilisateur
$idUser = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$idUser) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
}

// Récupérer les réponses du participant connecté pour ce quiz
$sql = "SELECT * FROM RESULTATS_QUIZZ WHERE id_quizz = ? AND id_user = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz, $idUser]);
$userResponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour vérifier si une réponse est valide
function isReponseValide($idQuestion, $userResponses, $dbh) {
    // Compter le nombre de choix corrects pour cette question
    $sql_correct = "SELECT COUNT(*) AS nb_correct_choices FROM CHOIX WHERE id_question = ? AND is_correct = 1";
    $stmt_correct = $dbh->prepare($sql_correct);
    $stmt_correct->execute([$idQuestion]);
    $result_correct = $stmt_correct->fetch(PDO::FETCH_ASSOC);
    $nb_correct_choices = $result_correct['nb_correct_choices'];

    // Compter le nombre de choix corrects sélectionnés par l'utilisateur
    $sql_user = "SELECT COUNT(*) AS nb_user_correct_choices FROM RESULTATS_QUIZZ WHERE id_question = ? AND id_user = ? AND is_selected = 1";
    $stmt_user = $dbh->prepare($sql_user);
    $stmt_user->execute([$idQuestion, $_SESSION['user_id']]);
    $result_user = $stmt_user->fetch(PDO::FETCH_ASSOC);
    $nb_user_correct_choices = $result_user['nb_user_correct_choices'];

    // La réponse est valide si tous les choix corrects ont été sélectionnés
    return ($nb_user_correct_choices == $nb_correct_choices);
}

// Initialiser le score Elo du participant
$sql_elo = "SELECT elo FROM USER WHERE id_USER = ?";
$stmt_elo = $dbh->prepare($sql_elo);
$stmt_elo->execute([$idUser]);
$user = $stmt_elo->fetch(PDO::FETCH_ASSOC);
$scoreParticipant = $user['elo'];

// Coefficient de gain, ajustable selon la sensibilité souhaitée
$K = 32;

// Variables pour le calcul des bonnes réponses
$bonnesReponses = 0;
$mauvaisesReponses = 0;

// Calculer le nombre de bonnes réponses
foreach ($userResponses as $response) {
    // Vérifier si la réponse est correcte
    $sql_choice = "SELECT is_correct FROM CHOIX WHERE id_CHOIX = ?";
    $stmt_choice = $dbh->prepare($sql_choice);
    $stmt_choice->execute([$response['id_choice']]);
    $choice = $stmt_choice->fetch(PDO::FETCH_ASSOC);

    if ($choice && $choice['is_correct'] == 1) {
        $bonnesReponses++;
    } else {
        $mauvaisesReponses++;
    }
}

// Limiter le nombre de bonnes réponses au nombre total de questions
$bonnesReponses = min($bonnesReponses, $totalQuestions);

// Affichage du pourcentage de bonnes réponses
$percentageCorrect = ($totalQuestions > 0) ? round(($bonnesReponses / $totalQuestions) * 100, 2) : 0;
$percentageCorrect = min($percentageCorrect, 100); // Limiter à 100%

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Résultat du Quiz: <?php echo htmlspecialchars($quiz['nom']); ?></h2>
        
        <p>Nombre de bonnes réponses : <?php echo $bonnesReponses; ?> / <?php echo $totalQuestions; ?></p>
        <p>Pourcentage de bonnes réponses : <?php echo $percentageCorrect; ?>%</p>
        
        <h3>Votre score Elo: <?php echo $scoreParticipant; ?></h3>


    </div>
</body>
</html>
