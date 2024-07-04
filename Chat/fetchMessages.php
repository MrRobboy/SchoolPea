<?php
session_start();
$temp = $_SESSION['email'];
require('./db.php');

$sql = "SELECT m.content, m.created_at, u.email, u.path_pp, DATE_FORMAT(m.date_heure,'%e/%m/%Y %H:%i') 
        FROM messages m
        JOIN USER u ON m.author = u.email
        ORDER BY m.created_at DESC";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
print_r($messages);
echo '</pre>';
?>

<div id="messages">
    <?php foreach ($messages as $message) : ?>
        <div class="message">
            <img src="<?php echo 'https://schoolpea.com/' . htmlspecialchars($message['path_pp']); ?>" alt="Profile Picture">
            <div class="message-content" <?php if ($message['email'] == $_SESSION['email']) echo 'style="background-color: #00ffb39e"'; ?>>
                <span><?php echo htmlspecialchars($message['email']); ?> <br> <?php echo $message["DATE_FORMAT(m.date_heure,'%e/%m/%Y %H:%i')"]; ?></span>
                <p><?php echo $message['content']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>