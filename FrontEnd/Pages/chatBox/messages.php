<?php
session_start();

// Inclure le fichier de connexion à la base de données PDO
require_once "connexion_bdd.php";

if (isset($_SESSION['user'])) {
    // Requête pour récupérer les messages
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY id_message DESC");

    if ($stmt->rowCount() == 0) {
        echo "Messagerie vide";
    } else {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Afficher les messages selon la logique de votre application
            if ($row['email'] == $_SESSION['user']) {
                ?>
                <div class="message your_message">
                    <span>Vous</span>
                    <p><?= htmlspecialchars($row['msg']) ?></p>
                    <p class="date"><?= $row['date'] ?></p>
                </div>
                <?php
            } else {
                ?>
                <div class="message others_message">
                    <span><?= htmlspecialchars($row['email']) ?></span>
                    <p><?= htmlspecialchars($row['msg']) ?></p>
                    <p class="date"><?= $row['date'] ?></p>
                </div>
                <?php
            }
        }
    }
} else {
    echo "Utilisateur non connecté";
}
?>
