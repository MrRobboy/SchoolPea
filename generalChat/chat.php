<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM USER WHERE id_USER='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="chat-container">
        <div id="message-box">
            <!-- Les messages seront chargés ici dynamiquement -->
        </div>
        <form id="message-form">
            <textarea id="message" placeholder="Écrire un message..."></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <script src="chat.js"></script>
</body>
</html>

<?php $conn->close(); ?>
