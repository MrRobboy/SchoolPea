document.addEventListener('DOMContentLoaded', (event) => {
    const messageBox = document.getElementById('message-box');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message');

    function loadMessages() {
        fetch('get_messages.php')
            .then(response => response.json())
            .then(data => {
                messageBox.innerHTML = '';
                data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message');
                    messageElement.innerHTML = `
                        <img src="${message.path_pp}" alt="Profile Picture">
                        <div class="message-info">
                            <span class="email">${message.email}</span>
                            <span class="timestamp">${message.sent_at}</span>
                        </div>
                        <div class="message-content">${message.message}</div>
                    `;
                    messageBox.appendChild(messageElement);
                });
            });
    }

    messageForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const message = messageInput.value;
        if (message.trim() !== '') {
            fetch('send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `content=${encodeURIComponent(message)}`
            }).then(response => response.text())
              .then(data => {
                  messageInput.value = '';
                  loadMessages();
              });
        }
    });

    setInterval(loadMessages, 3000); // Rafraîchir les messages toutes les 3 secondes
    loadMessages();
});
