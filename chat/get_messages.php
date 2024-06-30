<?php
include 'config.php';

$stmt = $conn->prepare("SELECT messages.message, messages.created_at, user.email FROM messages JOIN user ON messages.users_id = user.id_USER ORDER BY messages.created_at ASC");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);
?>
