<?php
header('Content-Type: application/json');

try {
    $dbh = new PDO('mysql:host=localhost;dbname=PA', 'root', 'root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->query('SELECT messages.message, messages.created_at, USER.firstname, USER.lastname FROM messages JOIN USER ON messages.user_id = USER.id_USER ORDER BY messages.created_at DESC');
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($messages);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
