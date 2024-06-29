<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['send_by'])) {
        $send_by = $_SESSION['send_by'];
        $message = $_POST['message'];

        $stmt = $pdo->prepare("INSERT INTO Messages (send_by, message) VALUES (:send_by, :message)");
        $stmt->bindParam(':send_by', $send_by);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    }
}
?>
