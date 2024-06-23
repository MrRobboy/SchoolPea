<?php
require_once('db.php');

if (!isset($_GET['id_quizz']) || !isset($_GET['score'])) {
    header('Location: index.php');
    exit();
}

$id_quizz = $_GET['id_quizz'];
$score = $_GET['score'];

// Récupérer les informations du quizz depuis la base de données
$stmt_quizz = $pdo->prepare("SELECT nom FROM QUIZZ WHERE id_quizz = ?");
$stmt_quizz->execute([$id_quizz]);
$quizz = $stmt_quizz->fetch(PDO::FETCH_ASSOC);

if (!$quizz) {
    header('Location: index.php');
    exit();
}

// Calculer les modifications d'elo (à adapter selon votre logique)
session_start(); // Démarrer la session pour récupérer l'id_user
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    // Récupérer l'elo actuel de l'utilisateur
    $stmt_elo = $pdo->prepare("SELECT elo FROM USER WHERE id_user = ?");
    $stmt_elo->execute([$id_user]);
    $row = $stmt_elo->fetch(PDO::FETCH_ASSOC);
    $elo_actuel = $row['elo'];

    // Calculer le nouvel elo
    // Exemple simplifié : +10 pour chaque quizz réussi, -5 pour chaque quizz raté
    $elo_modification = 0;
    if ($score > 0) {
        $elo_modification = 10 * $score;
    } else {
        $elo_modification = -5 * abs($score);
    }

    $nouvel_elo = $elo_actuel + $elo_modification;

    // Mettre à jour l'elo de l'utilisateur dans la base de données
    $stmt_update_elo = $pdo->prepare("UPDATE USER SET elo = ? WHERE id_user = ?");
    $stmt_update_elo->execute([$nouvel_elo, $id_user]);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat du Quizz - <?php echo $quizz['nom']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .elo-modification {
            animation: elo-change 2s linear;
        }

        @keyframes elo-change {
            0% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0); }
        }
    </style>
</head>
<body>
    <header>
        <h1>Résultat du Quizz - <?php echo $quizz['nom']; ?></h1>
    </header>
    <main>
        <section>
            <h2>Votre score : <?php echo $score; ?></h2>
            <?php if (isset($elo_modification)): ?>
                <h3>Votre elo <?php echo ($elo_modification >= 0) ? 'augmente' : 'diminue'; ?> de <?php echo abs($elo_modification); ?></h3>
                <p class="elo-modification"><?php echo ($elo_modification >= 0) ? '+' : ''; ?><?php echo $elo_modification; ?></p>
                <p>Nouvel elo : <?php echo $nouvel_elo; ?></p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
