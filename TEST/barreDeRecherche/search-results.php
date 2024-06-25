<?php
$host = 'localhost';
$db = 'PA';
$user = 'root';
$pass = 'root';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$query = isset($_GET['query']) ? $_GET['query'] : '';

$stmt = $pdo->prepare("SELECT nom FROM Quizz WHERE nom LIKE :query UNION SELECT nom FROM Cours WHERE nom  LIKE :query");
$stmt->execute(['query' => '%' . $query . '%']);
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la Recherche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .result-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Résultats de la Recherche pour "<?php echo htmlspecialchars($query); ?>"</h1>
    <div class="results">
        <?php foreach ($results as $result): ?>
        <div class="result-item"><?php echo htmlspecialchars($result['name']); ?></div>
        <?php endforeach; ?>
    </div>
</body>
</html>
