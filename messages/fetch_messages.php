<?php
include 'db_connect.php';

$messages = $conn->query("SELECT messages.message, messages.created_at, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at DESC");

while ($row = $messages->fetch(PDO::FETCH_ASSOC)) {
    echo "<div><strong>" . htmlspecialchars($row['username']) . "</strong> <span>" . $row['created_at'] . "</span><p>" . htmlspecialchars($row['message']) . "</p></div>";
}
?>
