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

$stmt = $pdo->prepare("SELECT name FROM QUIZZ WHERE name LIKE :query UNION SELECT name FROM COURS WHERE name LIKE :query");
$stmt->execute(['query' => '%' . $query . '%']);
$results = $stmt->fetchAll();

echo json_encode(['results' => $results]);
?>
