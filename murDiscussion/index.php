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
            display: flex;
            flex-direction: column-reverse; /* Afficher les messages du bas vers le haut */
        }
        .message {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: flex-start;
        }
        .message:last-child {
            border-bottom: none;
        }
        .message img {
            border-radius: 50%;
            margin-right: 10px;
            width: 50px;
            height: 50px;
        }
        .message-content {
            flex: 1;
        }
        .message p {
            margin: 0;
        }
        .message .timestamp {
            color: #666;
            font-size: 0.85em;
        }
        .message .email {
            color: #007bff;
            font-size: 0.85em;
            margin-top: 5px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageContainer = document.querySelector('.message-container');

            function loadMessages() {
                fetch('get_messages.php')
                    .then(response => response.json())
                    .then(data => {
                        messageContainer.innerHTML = '';

                        if (Array.isArray(data)) {
                            data.forEach(message => {
                                const messageDiv = document.createElement('div');
                                messageDiv.className = 'message';
                                messageDiv.innerHTML = `
                                    <img src="${message.path_pp}" alt="${message.firstname} ${message.lastname}">
                                    <div class="message-content">
                                        <p>${message.message}</p>
                                        <span class="timestamp">${message.created_at}</span>
                                        <span class="email">${message.email}</span>
                                    </div>
                                `;
                                messageContainer.appendChild(messageDiv);
                            });

                            // Faire défiler le conteneur vers le bas
                            messageContainer.scrollTop = messageContainer.scrollHeight;
                        } else {
                            messageContainer.innerHTML = '<p>Aucun message à afficher.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                    });
            }

            // Charger les messages toutes les 5 secondes
            loadMessages(); // Chargement initial
            setInterval(loadMessages, 5000); // Rafraîchir toutes les 5 secondes
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
