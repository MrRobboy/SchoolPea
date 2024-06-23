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

// Récupérer les questions du quizz
$stmt_questions = $dbh->prepare("SELECT id_question, question_text FROM QUESTIONS WHERE id_quizz = ?");
$stmt_questions->execute([$id_quizz]);
$questions = $stmt_questions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quizz - <?php echo $quizz['nom']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Quizz - <?php echo $quizz['nom']; ?></h1>
    </header>
    <main>
        <form action="resultatQuizz.php" method="post">
            <?php foreach ($questions as $question): ?>
                <section class="question">
                    <h2><?php echo $question['question_text']; ?></h2>
                    <?php
                    // Récupérer les choix pour chaque question
                    $stmt_choices = $dbh->prepare("SELECT id_choix, choix_text FROM CHOIX WHERE id_question = ?");
                    $stmt_choices->execute([$question['id_question']]);
                    $choices = $stmt_choices->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($choices as $choice):
                    ?>
                        <label>
                            <input type="radio" name="choix_<?php echo $question['id_question']; ?>" value="<?php echo $choice['id_choix']; ?>">
                            <?php echo $choice['choix_text']; ?>
                        </label>
                    <?php endforeach; ?>
                </section>
            <?php endforeach; ?>
            <input type="hidden" name="id_quizz" value="<?php echo $id_quizz; ?>">
            <button type="submit">Soumettre</button>
        </form>
    </main>
</body>
</html>
