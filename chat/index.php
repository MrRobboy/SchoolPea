<?php
session_start();
include('checkUser.php');
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
    if (isset($_SESSION['mail_valide'])) {
        $path .= '/headerL.php';
    } else {
        header('Location: https://schoolpea.com/Connexion');
    }
    include($path);
    ?>

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