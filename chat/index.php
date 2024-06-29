<?php
session_start();
if(!isset($_SESSION['id_USER'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat Général</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div id="messages"></div>
<textarea id="messageArea"></textarea>
<button id="sendBtn">Envoyer</button>
<input type="text" id="search" placeholder="Rechercher">
<button id="searchBtn">Rechercher</button>
<div id="onlineUsers"></div>

<script src="chat.js"></script>
</body>
</html>
