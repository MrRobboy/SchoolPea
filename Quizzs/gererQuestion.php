<?php
require_once('db.php');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id_quizz = $_GET['id'];

// Récupérer les informations du quizz depuis la base de données
$stmt = $dbh->prepare("SELECT nom FROM QUIZZ WHERE id_quizz = ?");
$stmt->execute([$id_quizz]);
$quizz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quizz) {
    header('Location: index.php');
    exit();
}

// Traitement du formulaire pour ajouter une nouvelle question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_text'])) {
    $question_text = $_POST['question_text'];

    $stmt = $dbh->prepare("INSERT INTO QUESTIONS (id_quizz, question_text) VALUES (?, ?)");
    $stmt->execute([$id_quizz, $question_text]);

    // Redirection vers la gestion des questions après ajout
    header("Location: gererQuestions.php?id=$id_quizz");
    exit();
}

// Récupérer les questions du quizz
$stmt_questions = $dbh->prepare("SELECT id_question, question_text FROM QUESTIONS WHERE id_quizz = ?");
$stmt_questions->execute([$id_quizz]);
$questions = $stmt_questions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Questions - <?php echo $quizz['nom']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gérer les Questions - <?php echo $quizz['nom']; ?></h1>
    </header>
    <main>
        <section class="questions">
            <h2>Questions</h2>
            <ul>
                <?php foreach ($questions as $question): ?>
                    <li><?php echo $question['question_text']; ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="ajouter-question">
            <h2>Ajouter une Question</h2>
            <form action="" method="post">
                <label>Texte de la Question</label>
                <textarea name="question_text" required></textarea>
                <button type="submit">Ajouter Question</button>
            </form>
        </section>
    </main>
</body>
</html>
