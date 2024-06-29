<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $message = $_POST['message'];

        try {
            $stmt = $pdo->prepare("INSERT INTO MESSAGE (sent_by, message) VALUES (:sent_by, :message)");
            $stmt->bindParam(':sent_by', $user_id);
            $stmt->bindParam(':message', $message);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
