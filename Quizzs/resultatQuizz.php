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

// Récupérer les réponses du participant connecté pour ce quiz
$idUser = $_SESSION['user_id'];

$sql = "SELECT * FROM RESULTATS_QUIZZ WHERE id_quizz = ? AND id_user = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz, $idUser]);
$userResponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialiser les variables pour le calcul du score
$bonnesReponses = 0;
$totalQuestions = count($questions);
$scoreParticipant = 0;

// Fonction pour vérifier si une réponse est valide
function isReponseValide($idQuestion, $userResponses, $dbh) {
    // Récupérer les choix corrects pour cette question
    $sql = "SELECT COUNT(*) AS nb_correct_choices FROM CHOIX WHERE id_question = ? AND is_correct = 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$idQuestion]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nb_correct_choices = $result['nb_correct_choices'];

    // Récupérer les choix corrects sélectionnés par l'utilisateur
    $sql = "SELECT COUNT(*) AS nb_user_correct_choices FROM RESULTATS_QUIZZ WHERE id_question = ? AND id_user = ? AND is_selected = 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$idQuestion, $_SESSION['user_id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nb_user_correct_choices = $result['nb_user_correct_choices'];

    // La réponse est valide si tous les choix corrects ont été sélectionnés
    return ($nb_user_correct_choices == $nb_correct_choices);
}

// Calculer le score du participant et mettre à jour les résultats du quiz
foreach ($questions as $question) {
    $bonnesReponsesQuestion = 0;

    // Vérifier les réponses du participant pour cette question
    foreach ($userResponses as $response) {
        if ($response['id_question'] == $question['id_question']) {
            // Vérifier si la réponse est correcte
            $sql = "SELECT is_correct FROM CHOIX WHERE id_CHOIX = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$response['id_choice']]);
            $choice = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($choice) {
                if ($choice['is_correct'] == 1) {
                    // Ajouter des points pour une réponse correcte
                    $scoreParticipant += 10; // Exemple de points pour une réponse correcte
                    $bonnesReponses++;
                } else {
                    // Déduire des points pour une réponse incorrecte (exemple)
                    $scoreParticipant -= 5; // Exemple de pénalité pour une réponse incorrecte
                }
            }
        }
    }

    // Vérifier si la réponse à la question est valide
    $reponseValide = isReponseValide($question['id_question'], $userResponses, $dbh);

    if ($reponseValide) {
        $bonnesReponses += 1;
    }
}

// Calculer le pourcentage de bonnes réponses
$pourcentageCorrect = ($totalQuestions > 0) ? round(($bonnesReponses / $totalQuestions) * 100, 2) : 0;

// Calculer le score Elo
// Coefficient de gain, ajustable selon la sensibilité souhaitée
$K = 32;

// Calcul du nouveau score Elo
if ($bonnesReponses > 0) {
    // Récupérer le score Elo actuel de l'utilisateur
    $sql = "SELECT elo FROM USER WHERE id_USER = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$idUser]);
    $currentElo = $stmt->fetchColumn();

    // Calculer le nouveau score Elo en ajoutant les nouveaux points calculés
    $scoreParticipant = $currentElo + $K * ($bonnesReponses / $totalQuestions);
}

// Mettre à jour le score Elo de l'utilisateur dans la base de données
$sql = "UPDATE USER SET elo = ? WHERE id_USER = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$scoreParticipant, $idUser]);

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
        <h3>Votre score Elo: <?php echo round($scoreParticipant, 2); ?></h3>
    </div>
</body>
</html>
