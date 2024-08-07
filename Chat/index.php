<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="chat.css">
</head>

<body>
    <?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    if (!empty($_SESSION['mail_valide'])) {
        $path .= '/headerL.php';
        include($path);
    } else {
        header('Location: https://schoolpea.com/Connexion');
    }
    ?>

    <div class="chat-container">
        <div class="messages" id="messages">
            <?php include 'fetchMessages.php'; ?>
        </div>
        <form action="sendMessage.php" method="post" id="message-form">
            <textarea name="content" placeholder="<?php echo $_SESSION['email']; ?>" required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>

    <script src="Chat.js"></script>
</body>

</html>