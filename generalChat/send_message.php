<?php
$host = 'localhost';
$db = 'PA';
$user = 'root';
$pass = 'pa';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$sent_by = $_POST['sent_by'];
$sent_to = $_POST['sent_to'];
$message = $_POST['message'];

$stmt = $pdo->prepare('INSERT INTO MESSAGE (message, sent_by, sent_to) VALUES (?, ?, ?)');
$stmt->execute([$message, $sent_by, $sent_to]);
?>
