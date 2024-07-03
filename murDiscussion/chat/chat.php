<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=PA';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT email, path_pp FROM users WHERE id_USER = :user_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat-container">
        <div class="messages" id="messages">
            <?php include 'fetch_messages.php'; ?>
        </div>
        <form action="send_message.php" method="post" id="message-form">
            <textarea name="content" required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
