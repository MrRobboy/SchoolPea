<?php
// Inclure le fichier common.php pour établir la connexion PDO et autres configurations
require_once('common.php');

// Démarrer la session si ce n'est pas déjà fait
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

// Vérifier s'il y a des questions
$sql = "SELECT * FROM QUESTIONS WHERE id_quizz = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($questions)) {
    echo "Aucune question trouvée pour ce quiz.";
    exit();
}

// Si le formulaire de rejouer le quiz est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rejouer_quiz'])) {
    // Supprimer les réponses du quiz précédent pour l'utilisateur actuel
    $idUser = $_SESSION['user_id'];
    $sql = "DELETE FROM RESULTATS_QUIZZ WHERE id_quizz = ? AND id_user = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$idQuizz, $idUser]);
    
    // Rediriger vers la première question du quiz pour recommencer
    header("Location: participerQuizz.php?id_quizz=$idQuizz");
    exit();
}

// Récupérer les réponses du participant connecté pour ce quiz
$idUser = $_SESSION['user_id'];

$sql = "SELECT * FROM RESULTATS_QUIZZ WHERE id_quizz = ? AND id_user = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz, $idUser]);
$userResponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialiser les variables pour le calcul du score
$bonnesReponses = 0;
$totalQuestions = count($questions);

// Fonction pour vérifier si une réponse est valide
function isReponseValide($idQuestion, $userResponses, $dbh) {
    // Récupérer les choix corrects pour cette question
    $sql = "SELECT id_CHOIX FROM CHOIX WHERE id_question = ? AND is_correct = 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$idQuestion]);
    $correctChoices = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Récupérer les choix sélectionnés par l'utilisateur pour cette question
    $sql = "SELECT id_choice FROM RESULTATS_QUIZZ WHERE id_question = ? AND id_user = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$idQuestion, $_SESSION['user_id']]);
    $userChoices = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Vérifier si tous les choix corrects sont présents et aucun autre choix n'est sélectionné
    sort($correctChoices);
    sort($userChoices);

    return ($correctChoices === $userChoices);
}

// Calculer le nombre de questions correctement répondues
foreach ($questions as $question) {
    if (isReponseValide($question['id_question'], $userResponses, $dbh)) {
        $bonnesReponses++;
    }
}

// Calculer le pourcentage de bonnes réponses
$pourcentageCorrect = ($totalQuestions > 0) ? round(($bonnesReponses / $totalQuestions) * 100, 2) : 0;

// Récupérer le score Elo actuel de l'utilisateur
$sql = "SELECT elo FROM USER WHERE id_USER = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idUser]);
$currentElo = $stmt->fetchColumn();

// Calculer le nouveau score Elo
// Coefficient de gain, ajustable selon la sensibilité souhaitée
$K = 42;

// Calcul du nouveau score Elo
if ($bonnesReponses < ($totalQuestions - $bonnesReponses)) {
    // Si les mauvaises réponses sont plus nombreuses que les bonnes, l'utilisateur perd des points
    $newElo = $currentElo - $K * (($totalQuestions - $bonnesReponses) / $totalQuestions);
} else {
    // Sinon, l'utilisateur gagne des points
    $newElo = $currentElo + $K * ($bonnesReponses / $totalQuestions);
}

// Mettre à jour le score Elo de l'utilisateur dans la base de données
$sql = "UPDATE USER SET elo = ? WHERE id_USER = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$newElo, $idUser]);

// Récupérer le classement de l'utilisateur
$sql = "SELECT FIND_IN_SET(elo, (SELECT GROUP_CONCAT(elo ORDER BY elo DESC) FROM USER)) AS rank FROM USER WHERE id_USER = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idUser]);
$userelo = $stmt->fetchColumn();
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
        <p>Pourcentage de bonnes réponses : <?php echo $pourcentageCorrect; ?>%</p>
        <h3>Votre score Elo: <?php echo round($newElo, 2); ?></h3>
        
        <!-- Boutons pour rejouer, accueil et classement -->
        <div class="buttons">
            <form action="" method="post">
                <input type="hidden" name="rejouer_quiz" value="1">
                <button type="submit">Rejouer le Quiz</button>
            </form>
            <a href="../index.php" class="button">Retour à l'accueil</a>
            <a href="../../Classement/index.php" class="button">Voir le Classement</a>
        </div>
        
        <!-- Afficher le classement de l'utilisateur -->
        <p>Votre classement : <?php echo $userelo; ?></p>
    </div>
</body>
</html>
