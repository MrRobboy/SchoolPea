function fetchMessages() {
    fetch('fetchMessages.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('messages').innerHTML = data;
        })
        .catch(error => console.error('Error fetching messages:', error));
}

// Fetch messages every 3 seconds
setInterval(fetchMessages, 3000);

// Handle form submission
document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('sendMessage.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        fetchMessages();  // Refresh messages after sending a new one
        this.reset();  // Clear the form
    })
    .catch(error => console.error('Error sending message:', error));
});
