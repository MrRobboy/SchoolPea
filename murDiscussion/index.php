<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer un Message</title>
    <style>
        .message-container {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            max-height: 300px;
            overflow-y: auto;
        }
        .message {
            padding: 5px;
            border-bottom: 1px solid #eee;
        }
        .message:last-child {
            border-bottom: none;
        }
        .message p {
            margin: 0;
        }
        .message .timestamp {
            color: #666;
            font-size: 0.85em;
        }
    </style>
</head>
<body>

    <!-- Conteneur pour afficher les messages -->
    <div class="message-container">
        <?php
        // Inclure le script pour récupérer les messages
        include 'display_messages.php';

        // Afficher les messages
        foreach ($messages as $message) {
            echo '<div class="message">';
            echo '<p>' . htmlspecialchars($message['message']) . '</p>';
            echo '<span class="timestamp">' . $message['created_at'] . '</span>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Formulaire pour envoyer un message -->
    <form method="post" action="send_message.php">
        <input type="hidden" name="user_id" value="3"> <!-- Changez cette valeur dynamiquement selon l'utilisateur connecté -->
        <textarea name="message" rows="4" cols="50" placeholder="Entrez votre message ici..."></textarea>
        <button type="submit">Envoyer</button>
    </form>

</body>
</html>
