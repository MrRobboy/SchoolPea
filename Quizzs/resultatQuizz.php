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

// Initialiser le score Elo du participant
$sql = "SELECT elo FROM USER WHERE id_USER = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idUser]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$scoreParticipant = $user['elo'];

// Coefficient de gain, ajustable selon la sensibilité souhaitée
$K = 32;

// Calculer le nouveau score Elo du participant après chaque question
foreach ($questions as $question) {
    $bonnesReponses = 0;
    $mauvaisesReponses = 0;

    // Vérifier les réponses du participant pour cette question
    foreach ($userResponses as $response) {
        if ($response['id_question'] == $question['id_question']) {
            // Vérifier si la réponse est correcte
            $sql = "SELECT is_correct FROM CHOIX WHERE id_CHOIX = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$response['id_choice']]);
            $choice = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($choice && $choice['is_correct'] == 1) {
                $bonnesReponses++;
            } else {
                $mauvaisesReponses++;
            }
        }
    }

    // Déterminer si la réponse à la question est valide
    $reponseValide = isReponseValide($question['id_question'], $userResponses, $dbh);

    // Calculer l'espérance de gain
    $E = $reponseValide ? 1 : 0;

    // Calculer R en fonction de la validité de la réponse
    $R = ($bonnesReponses > 0 && $mauvaisesReponses == 0) ? 1 : 0;

    // Calcul du nouveau score Elo
    if ($bonnesReponses > $mauvaisesReponses) {
        // Gain d'Elo proportionnel aux bonnes réponses
        $gainElo = $K * ($bonnesReponses / $totalQuestions);
        $scoreParticipant += $gainElo * ($R - $E);
    } elseif ($mauvaisesReponses > $bonnesReponses) {
        // Perte d'Elo proportionnelle aux mauvaises réponses
        $perteElo = $K * ($mauvaisesReponses / $totalQuestions);
        $scoreParticipant -= $perteElo * ($E - $R);
    }

    // Mettre à jour les réponses du participant dans la table RESULTATS_QUIZZ
    // Note: Cela doit être adapté selon votre structure de base de données pour mettre à jour les réponses du participant après chaque question.
}

// Mettre à jour le score Elo de l'utilisateur dans la table USER
$sql = "UPDATE USER SET elo = ? WHERE id_USER = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$scoreParticipant, $idUser]);

// Affichage des résultats (exemple simplifié pour un seul participant)
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
        
        <?php
        // Afficher le nombre de bonnes réponses et le pourcentage
        echo "<p>Nombre de bonnes réponses : $bonnesReponses / $totalQuestions</p>";
        $pourcentageCorrect = ($totalQuestions > 0) ? round(($bonnesReponses / $totalQuestions) * 100, 2) : 0;
        echo "<p>Pourcentage de bonnes réponses : $pourcentageCorrect%</p>";
        ?>
        
        <h3>Votre score Elo: <?php echo $scoreParticipant; ?></h3>


    </div>
</body>
</html>
