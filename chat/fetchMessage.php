<?php
session_start();
include 'db.php';

try {
    $sql = "SELECT MESSAGE.message, MESSAGE.sent_at, USER.email, USER.path_pp 
            FROM MESSAGE 
            JOIN USER ON MESSAGE.sent_by = USER.id_USER 
            ORDER BY MESSAGE.sent_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($messages);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
