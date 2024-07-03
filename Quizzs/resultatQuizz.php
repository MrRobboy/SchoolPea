<?php
require_once('common.php');
// Si `session_start()` n'est pas déjà appelé dans 'common.php', vous pouvez le démarrer ici
// session_start();

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
$idUser = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

if (!$idUser) {
    echo "Utilisateur non connecté.";
    exit();
}

// Récupérer les réponses du participant connecté pour ce quiz
$sql = "SELECT * FROM RESULTATS_QUIZZ WHERE id_quizz = ? AND id_user = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$idQuizz, $idUser]);
$userResponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Compter le nombre de bonnes réponses
$correctAnswers = 0;
foreach ($userResponses as $response) {
    $sql = "SELECT is_correct FROM CHOIX WHERE id_CHOIX = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$response['id_choice']]);
    $choice = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($choice && $choice['is_correct'] == 1) {
        $correctAnswers++;
    }
}

// Calculer le pourcentage de bonnes réponses
$percentageCorrect = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

// Calculer l'élo du participant
$initialElo = 1000; // Score de départ
$K = 32; // Coefficient de gain, ajustable selon la sensibilité souhaitée

// Fonction pour calculer l'espérance de gain (simplifiée pour cet exemple)
function calculerEsperanceDeGain($participant, $question)
{
    // Ici, vous pouvez implémenter votre propre logique pour calculer l'espérance de gain
    // en fonction de la difficulté de la question, du score actuel du participant, etc.
    // Pour cet exemple simplifié, on suppose un calcul basique.
    return 0.5; // Exemple: 50% de chance de gain
}

// Initialiser le score du participant
$scoreParticipant = $initialElo;

// Liste des participants (pour cet exemple, un seul participant)
$listeDesParticipants = [
    [
        'id' => $idUser,
        'score' => $scoreParticipant,
    ]
];

// Calculer le nouveau score du participant après chaque question
foreach ($questions as $question) {
    foreach ($listeDesParticipants as &$participant) {
        $E = calculerEsperanceDeGain($participant, $question);

        // Supposons que l'utilisateur a toujours répondu correctement (pour cet exemple simplifié)
        $R = 1; // Réponse correcte

        // Calcul du nouveau score
        $nouveauScore = $participant['score'] + $K * ($R - $E);

        // Mettre à jour le score du participant
        $participant['score'] = $nouveauScore;
    }

    // Trier la liste des participants par ordre décroissant des scores après chaque question
    usort($listeDesParticipants, function ($a, $b) {
        return $b['score'] - $a['score'];
    });
}

// Affichage du classement général des participants (ici, un seul participant)
$classementGeneralDesParticipants = $listeDesParticipants;

// Déterminer la couleur basée sur le gain/perte d'élo
$eloDiff = $classementGeneralDesParticipants[0]['score'] - $initialElo;
if ($eloDiff > 0) {
    $eloColor = 'green'; // Gain d'élo (positif)
} elseif ($eloDiff < 0) {
    $eloColor = 'red'; // Perte d'élo (négatif)
} else {
    $eloColor = 'orange'; // Aucun changement d'élo (nul)
}
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
        <p>Nombre de questions réussies: <?php echo $correctAnswers; ?> / <?php echo $totalQuestions; ?> (<?php echo $percentageCorrect; ?>%)</p>
        
        <h3>Votre score Elo: <span style="color: <?php echo $eloColor; ?>"><?php echo $classementGeneralDesParticipants[0]['score']; ?></span></h3>

        <h3>Classement général</h3>
        <ol>
            <?php foreach ($classementGeneralDesParticipants as $participant) : ?>
                <li>Participant <?php echo $participant['id']; ?> - Score: <?php echo $participant['score']; ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</body>
</html>
