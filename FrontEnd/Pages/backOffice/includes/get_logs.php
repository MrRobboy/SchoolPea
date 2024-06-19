<?php
include 'db.php';

try {
    $stmt = $pdo->query('SELECT * FROM Logs');
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
