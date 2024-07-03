<?php
require_once('db.php');

$sql = "SELECT m.content, m.created_at, u.email, u.path_pp 
        FROM messages m
        JOIN USER u ON m.author = u.email
        ORDER BY m.created_at DESC";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="messages">
    <?php foreach ($messages as $message) : ?>
        <div class="message">
            <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] . htmlspecialchars($message['path_pp']); ?>" alt="Profile Picture">
            <div class="message-content">
                <p><?php echo htmlspecialchars($message['content']); ?></p>
                <span><?php echo htmlspecialchars($message['email']); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>