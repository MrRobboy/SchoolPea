document.addEventListener('DOMContentLoaded', function () {
    loadMessages();
});

function loadMessages() {
    fetch('load_messages.php')
        .then(response => response.json())
        .then(data => {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.innerHTML = '';
            data.forEach(msg => {
                const messageElement = document.createElement('div');
                messageElement.classList.add('message');
                messageElement.innerHTML = `<div class="user">${msg.firstname} ${msg.lastname} <span class="timestamp">${msg.created_at}</span></div><div class="text">${msg.message}</div>`;
                messagesDiv.appendChild(messageElement);
            });
        });
}

function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    if (message) {
        fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `message=${encodeURIComponent(message)}`
        })
        .then(response => response.text())
        .then(() => {
            messageInput.value = '';
            loadMessages();
        });
    }
}
