document.addEventListener("DOMContentLoaded", function () {
    fetchMessages(); // Appel de la fonction fetchMessages dès le chargement de la page
    setInterval(fetchMessages, 3000); // Mise en place de l'intervalle

    document
        .getElementById("message-form")
        .addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch("send_message.php", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.text())
                .then((data) => {
                    fetchMessages();
                    this.reset();
                })
                .catch((error) =>
                    console.error("Error sending message:", error)
                );
        });
});

function fetchMessages() {
    fetch("fetchMessages.php")
        .then((response) => response.text())
        .then((data) => {
            document.getElementById("messages").innerHTML = data;
            scrollToBottom(); // Scroll vers le bas après la mise à jour des messages
        })
        .catch((error) => console.error("Error fetching messages:", error));
}

function scrollToBottom() {
    const messagesDiv = document.getElementById("messages");
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}
