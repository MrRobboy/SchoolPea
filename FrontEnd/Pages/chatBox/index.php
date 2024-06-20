<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Messagerie</h1>
        <div class="chatbox">
            <?php
            // Affichage des messages entre deux utilisateurs
            require_once 'config.php';

            // Exemple : utilisateur 1 et utilisateur 2
            $user1_id = 1;
            $user2_id = 2;

            // Récupération des messages entre ces deux utilisateurs
            $query = "SELECT * FROM messages 
                      WHERE (sender_id = :user1_id AND receiver_id = :user2_id)
                      OR (sender_id = :user2_id AND receiver_id = :user1_id)
                      ORDER BY created_at ASC";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user1_id', $user1_id);
            $stmt->bindParam(':user2_id', $user2_id);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $username = htmlspecialchars($row['username']);
                $message = htmlspecialchars($row['message']);
                $created_at = htmlspecialchars($row['created_at']);

                echo "<div class='message'>";
                echo "<span class='username'>$username:</span>";
                echo "<span class='message-text'>$message</span>";
                echo "<span class='timestamp'>$created_at</span>";
                echo "</div>";
            }
            ?>
        </div>
        
        <form action="process.php" method="post" class="message-form">
            <input type="hidden" name="sender_id" value="<?php echo $user1_id; ?>">
            <input type="hidden" name="receiver_id" value="<?php echo $user2_id; ?>">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>
</html>
