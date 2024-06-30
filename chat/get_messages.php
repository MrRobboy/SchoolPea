<?php
include 'db.php';

$stmt = $dbh->prepare("SELECT messages.message, messages.created_at, USER.email FROM messages JOIN USER ON messages.users_id = USER.id_USER ORDER BY messages.created_at ASC");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);
?>
