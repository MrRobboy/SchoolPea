<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT MESSAGE.message, MESSAGE.sent_at, USER.email, USER.path_pp 
        FROM MESSAGE 
        JOIN USER ON MESSAGE.sent_by = USER.id_USER 
        ORDER BY MESSAGE.sent_at DESC";

$result = $conn->query($sql);
$messages = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

$conn->close();

echo json_encode($messages);
?>
