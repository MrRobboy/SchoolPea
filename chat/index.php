<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    session_start(); // Assurez-vous que la session est démarrée
    $path = $_SERVER['DOCUMENT_ROOT'];
    if (isset($_SESSION['mail_valide'])) {
        $path .= '/headerL.php';
    } else {
        header('Location: https://schoolpea.com/Connexion');
        exit(); // Assurez-vous de sortir du script après la redirection
    }
    include($path);
    ?>

    <div class="chat-container">
        <div class="messages" id="messages">
            <!-- Messages seront chargés ici par JavaScript -->
        </div>
        <form action="send_message.php" method="post" id="message-form">
            <textarea name="content" required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>

</html>