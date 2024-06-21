<?php
// Vérification si $_SESSION['score'] est défini
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number'];
    $selected_choice = $_POST['choice'];
    $next = $number + 1;

    // Récupérer le nombre total de questions
    $query = "SELECT * FROM questions";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $total = $stmt->rowCount();

    // Récupérer le choix correct
    $q = "SELECT * FROM choices WHERE question_number = :number AND is_correct = 1";
    $stmt = $pdo->prepare($q);
    $stmt->bindParam(':number', $number, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $correct_choice = $row['id'];

    // Comparer la réponse avec le résultat
    if ($correct_choice == $selected_choice) {
        $_SESSION['score']++;
    }

    // Redirection en fonction du numéro de question
    if ($number == $total) {
        header("Location: final.php");
        exit();
    } else {
        header("Location: question.php?n=" . $next . "&score=" . $_SESSION['score']);
        exit();
    }
}
?>
