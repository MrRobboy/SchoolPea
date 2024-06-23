<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PA";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

$quizz_query = "SELECT * FROM QUIZZ";
$quizz_result = $conn->query($quizz_query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir Tous les Quizz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Voir Tous les Quizz</h1>
    <ul>
        <?php while ($quizz = $quizz_result->fetch_assoc()) { ?>
            <li><a href="quiz.php?id=<?php echo $quizz['id']; ?>"><?php echo $quizz['titre']; ?></a></li>
        <?php } ?>
    </ul>
</body>
</html>
