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
            messages.forEach(function(message){
                $('#messages').append('<div class="message"><img src="' + message.profile_picture + '" alt="Profile Picture"><p>' + message.username + ' (' + new Date(message.timestamp).toLocaleTimeString() + '): ' + message.message + '</p></div>');
            });
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
            users.forEach(function(user){
                $('#onlineUsers').append('<p>' + user.username + '</p>');
            });
        }
    });
}

$(document).ready(function(){
    loadMessages();
    setInterval(loadMessages, 5000); // Recharge les messages toutes les 5 secondes

    loadOnlineUsers();
    setInterval(loadOnlineUsers, 5000); // Recharge la liste des utilisateurs en ligne toutes les 5 secondes

    $('#sendBtn').on('click', function() {
        var message = $('#messageArea').val();
        $.ajax({
            url: 'sendMessage.php',
            type: 'POST',
            data: {
                'message': message
            },
            success: function(response) {
                $('#messageArea').val('');
                loadMessages();
            }
        });
    });

    $('#searchBtn').on('click', function() {
        var keyword = $('#search').val();
        $.ajax({
            url: 'searchMessages.php',
            type: 'GET',
            data: {
                'keyword': keyword
            },
            success: function(response) {
                var messages = JSON.parse(response);
                $('#messages').empty();
                messages.forEach(function(message){
                    $('#messages').append('<div class="message"><img src="' + message.profile_picture + '" alt="Profile Picture"><p>' + message.username + ' (' + new Date(message.timestamp).toLocaleTimeString() + '): ' + message.message + '</p></div>');
                });
            }
        });
    });
});
