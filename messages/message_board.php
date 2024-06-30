<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Connexion/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO messages (user_id, message) VALUES (:user_id, :message)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
}

$messages = $conn->query("SELECT messages.message, messages.created_at, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Message Board</title>
</head>
<body>
<h1>Global Message Board</h1>
<form method="POST" action="">
    <textarea name="message" required></textarea>
    <button type="submit">Send</button>
</form>
<div id="messages">
    <?php while ($row = $messages->fetch(PDO::FETCH_ASSOC)) { ?>
        <div>
            <strong><?php echo htmlspecialchars($row['username']); ?></strong>
            <span><?php echo $row['created_at']; ?></span>
            <p><?php echo htmlspecialchars($row['message']); ?></p>
        </div>
    <?php } ?>
</div>
<script>
    // Auto-refresh messages every 5 seconds
    setInterval(() => {
        fetch('fetch_messages.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('messages').innerHTML = data;
            });
    }, 5000);
</script>
</body>
</html>
