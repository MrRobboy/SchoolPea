<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die('Utilisateur non connecté.');
}
$user_id = $_SESSION['user_id'];
?>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function loadMessages() {
                fetch('get_messages.php')
                    .then(response => response.json())
                    .then(data => {
                        const messageContainer = document.querySelector('.message-container');
                        messageContainer.innerHTML = '';

                        if (Array.isArray(data)) {
                            data.forEach(message => {
                                const messageDiv = document.createElement('div');
                                messageDiv.className = 'message';
                                messageDiv.innerHTML = `
                                    <p>${message.message}</p>
                                    <span class="timestamp">${message.created_at}</span>
                                `;
                                messageContainer.appendChild(messageDiv);
                            });
                        } else {
                            messageContainer.innerHTML = '<p>Aucun message à afficher.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                    });
            }

            loadMessages();
        });
    </script>
</head>
<body>

    <div class="message-container">
        <!-- Les messages seront chargés ici par JavaScript -->
    </div>

    <!-- Formulaire pour envoyer un message -->
    <form method="post" action="send_message.php">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <textarea name="message" rows="4" cols="50" placeholder="Entrez votre message ici..."></textarea>
        <button type="submit">Envoyer</button>
    </form>

</body>
</html>
