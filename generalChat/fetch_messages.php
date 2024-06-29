<?php
$host = 'localhost';
$db = 'PA';
$user = 'root';
$pass = 'root';
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

$sent_by = $_GET['sent_by'];
$sent_to = $_GET['sent_to'];

$stmt = $pdo->prepare('
    SELECT m.message, m.sent_at, u.firstname, u.lastname 
    FROM MESSAGE m 
    JOIN USER u ON m.sent_by = u.id_USER 
    WHERE (m.sent_by = :sent_by AND m.sent_to = :sent_to) OR (m.sent_by = :sent_to AND m.sent_to = :sent_by) 
    ORDER BY m.sent_at DESC
');
$stmt->execute(['sent_by' => $sent_by, 'sent_to' => $sent_to]);
$messages = $stmt->fetchAll();
echo json_encode(array_reverse($messages));
?>
