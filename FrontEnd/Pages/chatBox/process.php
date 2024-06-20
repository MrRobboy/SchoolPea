<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Insertion du message dans la base de données
    $query = "INSERT INTO messages (sender_id, receiver_id, message) 
              VALUES (:sender_id, :receiver_id, :message)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sender_id', $sender_id);
    $stmt->bindParam(':receiver_id', $receiver_id);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        // Redirection vers la page principale après l'envoi du message
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
?>
