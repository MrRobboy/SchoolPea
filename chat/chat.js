var page = 1;

function loadMessages() {
    $.ajax({
        url: 'getMessages.php',
        type: 'GET',
        data: {
            'page': page
        },
        success: function(response) {
            var messages = JSON.parse(response);
            $('#messages').empty();
            messages.forEach(function(message) {
                $('#messages').append(
                    '<div class="message">' +
                        '<img src="' + message.profile_picture + '" alt="Profile Picture">' +
                        '<p>' + message.username + ' (' + new Date(message.timestamp).toLocaleTimeString() + '): ' + message.message + '</p>' +
                    '</div>'
                );
            });
        },
        error: function(xhr, status, error) {
            console.error("Error loading messages: ", status, error);
        }
    });
}

function loadOnlineUsers() {
    $.ajax({
        url: 'getOnlineUsers.php',
        type: 'GET',
        success: function(response) {
            var users = JSON.parse(response);
            $('#onlineUsers').empty();
            users.forEach(function(user) {
                $('#onlineUsers').append('<p>' + user.username + '</p>');
            });
        },
        error: function(xhr, status, error) {
            console.error("Error loading online users: ", status, error);
        }
    });
}

$(document).ready(function() {
    loadMessages();
    setInterval(loadMessages, 5000); // Recharge les messages toutes les 5 secondes

    loadOnlineUsers();
    setInterval(loadOnlineUsers, 5000); // Recharge la liste des utilisateurs en ligne toutes les 5 secondes

    $('#sendBtn').on('click', function() {
        var message = $('#messageArea').val();
        if (message.trim() !== "") {
            $.ajax({
                url: 'sendMessage.php', // Assurez-vous que ce chemin est correct
                type: 'POST',
                data: {
                    'message': message
                },
                success: function(response) {
                    $('#messageArea').val('');
                    loadMessages();
                },
                error: function(xhr, status, error) {
                    console.error("Error sending message: ", status, error);
                }
            });
        } else {
            alert("Le message ne peut pas être vide.");
        }
    });

    $('#searchBtn').on('click', function() {
        var keyword = $('#search').val();
        if (keyword.trim() !== "") {
            $.ajax({
                url: 'searchMessages.php', // Assurez-vous que ce chemin est correct
                type: 'GET',
                data: {
                    'keyword': keyword
                },
                success: function(response) {
                    var messages = JSON.parse(response);
                    $('#messages').empty();
                    messages.forEach(function(message) {
                        $('#messages').append(
                            '<div class="message">' +
                                '<img src="' + message.profile_picture + '" alt="Profile Picture">' +
                                '<p>' + message.username + ' (' + new Date(message.timestamp).toLocaleTimeString() + '): ' + message.message + '</p>' +
                            '</div>'
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error searching messages: ", status, error);
                }
            });
        } else {
            alert("Le mot-clé de recherche ne peut pas être vide.");
        }
    });
});
