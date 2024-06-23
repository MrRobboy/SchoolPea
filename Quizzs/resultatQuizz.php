<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

if (!isset($_POST['id_quizz'])) {
    header('Location: index.php');
    exit();
}

$id_quizz = $_POST['id_quizz'];

// Récupérer les réponses soumises par l'utilisateur
$answers = [];
foreach ($_POST as $key => $value) {
    if (strpos($key, 'choix_') === 0) {
        $id_question = substr($key, strlen('choix_'));
        $id_choix = $value;
        $answers[$id_question] = $id_choix;
    }
}

// Calculer le score de l'utilisateur
$score = 0;
foreach ($answers as $id_question => $id_choix) {
    $stmt = $dbh->prepare("SELECT is_correct FROM CHOIX WHERE id_choix = ?");
    $stmt->execute([$id_choix]);
    $choice = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($choice && $choice['is_correct'] == 1) {
        $score++;
    }
}

// Enregistrer le score de l'utilisateur dans la base de données
// Vous devez adapter cette partie selon votre structure de base de données
session_start(); // Démarrer la session pour récupérer l'id_user

if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    // Insérer le score dans la table des participations ou une table dédiée
    $stmt_insert_score = $dbh->prepare("INSERT INTO PARTICIPATION_QUIZZ (id_quizz, id_user, score) VALUES (?, ?, ?)");
    $stmt_insert_score->execute([$id_quizz, $id_user, $score]);
}

// Redirection vers une page de résultats ou de confirmation
header("Location: resultat.php?id_quizz=$id_quizz&score=$score");
exit();
?>
