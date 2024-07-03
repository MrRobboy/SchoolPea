function fetchMessages() {
    fetch('fetchMessages.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('messages').innerHTML = data;
        })
        .catch(error => console.error('Error fetching messages:', error));
}

fetchMessages();

document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('sendMessage.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        fetchMessages(); 
        this.reset(); 
    })
    .catch(error => console.error('Error sending message:', error));
});

setInterval(fetchMessages, 3000);