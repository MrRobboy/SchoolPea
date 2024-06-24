<?php
session_start();

if (!isset($_SESSION['user'])) {
    // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    header("location:index.php");
    exit;
}

$user = $_SESSION['user'];

require_once 'connexion_bdd.php';

if (isset($_POST['send'])) {
    // Vérifier et insérer le message dans la base de données
    if (!empty($_POST['message'])) {
        $message = $_POST['message'];

        // Insérer le message dans la base de données
        $insert_stmt = $pdo->prepare("INSERT INTO MESSAGE (message, sent_by, sent_to, date_envoi) VALUES (?, ?, ?, NOW())");
        $insert_stmt->execute([$message, $user_id, $sent_to_id]);

        // Actualiser la page
        header('location:chat.php');
        exit;
    } else {
        header('location:chat.php'); // Redirection si le message est vide
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | <?= $user ?></title>
    <link rel="stylesheet" type="text/css" href="chat.css">
</head>

<body>
    <div class="chat">
        <div class="button-email">
            <span><?= $user ?></span>
            <a href="deconnexion.php" class="Deconnexion_btn">Déconnexion</a>
        </div>
        <div class="messages_box">Chargement...</div>

        <!-- Formulaire d'envoi de message -->
        <form action="" class="send_message" method="POST">
            <textarea name="message" cols="30" rows="2" placeholder="Votre message" required></textarea>
            <input type="submit" value="Envoyer" name="send">
        </form>
    </div>

    <script>
        // Actualisation automatique du chat en utilisant AJAX
        var message_box = document.querySelector('.messages_box');
        setInterval(function() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    message_box.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "messages.php", true);
            xhttp.send();
        }, 500); // Actualiser le chat toutes les 500 ms
    </script>
</body>

</html>