document.addEventListener("DOMContentLoaded", () => {
    const chatWindow = document.getElementById("chat-window");
    const messageInput = document.getElementById("message");
    const sendButton = document.getElementById("send");
    const sentBy = document.getElementById("sent_by").value;
    const sentTo = document.getElementById("sent_to").value;

    function fetchMessages() {
        fetch(`fetch_messages.php?sent_by=${sentBy}&sent_to=${sentTo}`)
            .then(response => response.json())
            .then(data => {
                chatWindow.innerHTML = data.map(message => `<p><strong>${message.firstname} ${message.lastname}:</strong> ${message.message} <em>${message.sent_at}</em></p>`).join("");
                chatWindow.scrollTop = chatWindow.scrollHeight;
            });
    }

    sendButton.addEventListener("click", () => {
        const message = messageInput.value.trim();
        
        if (message) {
            fetch("send_message.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `sent_by=${sentBy}&sent_to=${sentTo}&message=${message}`
            }).then(() => {
                messageInput.value = "";
                fetchMessages();
            });
        }
    });

    // Fetch messages every 3 seconds
    setInterval(fetchMessages, 3000);
    fetchMessages();
});
