<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo 'User not logged in';
    exit;
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=PA', 'root', 'root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $stmt = $dbh->prepare('INSERT INTO messages (user_id, message) VALUES (:user_id, :message)');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();

    echo 'Message sent';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
