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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    
    $sql = "INSERT INTO MESSAGE (sent_by, message) VALUES ('$user_id', '$content')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Message envoyé avec succès.";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
