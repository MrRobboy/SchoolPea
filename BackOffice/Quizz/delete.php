<?php
session_start();
$_GET;
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

$dbh->exec('USE PA');

$idQuiz = $_GET['id'];

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Stocker l'URL actuelle
    header("Location: login.php");
    exit();
}

// Récupérer le chemin de l'image associée au quiz
$stmt = $dbh->prepare("SELECT path_image_pres FROM QUIZZ WHERE id_QUIZZ = :id");
$stmt->bindValue(':id', $idQuiz);
$result = $stmt->execute();
$imagePath = $stmt->fetch(PDO::FETCH_ASSOC);

// Supprimer le quiz de la base de données
$stmt1 = $dbh->prepare("DELETE FROM QUIZZ WHERE id_QUIZZ = :id");
$stmt1->bindValue(':id', $idQuiz);
$result1 = $stmt1->execute();

// Supprimer l'image associée au quiz, si elle existe
if ($imagePath && file_exists($imagePath['path_image_pres'])) {
    unlink($imagePath['path_image_pres']);
}

// Redirection en fonction du résultat de la suppression
if ($result1) {
    header('Location: https://schoolpea.com/BackOffice/Quizz/index.php?success=1');
} else {
    header('Location: https://schoolpea.com/BackOffice/Quizz');
}
exit();
?>
