document.addEventListener("DOMContentLoaded", function() {
    const messagesBox = document.getElementById('messages-box');
    const messageInput = document.getElementById('message-input');

    function fetchMessages() {
        fetch('fetchMessages.php')
            .then(response => response.json())
            .then(data => {
                messagesBox.innerHTML = '';
                data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message');

                    const profilePhoto = document.createElement('img');
                    profilePhoto.src = message.path_pp;
                    profilePhoto.classList.add('profile-photo');

                    const messageBubble = document.createElement('div');
                    messageBubble.classList.add('message-bubble');
                    messageBubble.textContent = message.message;

                    const messageEmail = document.createElement('div');
                    messageEmail.classList.add('message-email');
                    messageEmail.textContent = message.email;

                    messageElement.appendChild(profilePhoto);
                    messageElement.appendChild(messageBubble);
                    messageElement.appendChild(messageEmail);

                    messagesBox.appendChild(messageElement);
                });
            });
    }

    fetchMessages();
    setInterval(fetchMessages, 5000);

    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const message = messageInput.value;
            if (message.trim() !== '') {
                fetch('sendMessage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `message=${encodeURIComponent(message)}`
                }).then(() => {
                    messageInput.value = '';
                    fetchMessages();
                });
            }
        }
    });
});
