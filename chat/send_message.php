<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $stmt = $dbh->prepare("INSERT INTO messages (message, users_id) VALUES (:message, :user_id)");
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}
?>
