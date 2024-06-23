<?php
session_start();

// Inclure le fichier de connexion à la base de données PDO
require_once "connexion_bdd.php";

if (isset($_SESSION['user'])) {
    // Requête pour récupérer les messages
    $stmt = $pdo->query("SELECT * FROM MESSAGE ORDER BY id_message DESC");

    if ($stmt->rowCount() == 0) {
        echo "Messagerie vide";
    } else {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Assurez-vous que les clés existent avant de les utiliser
            if (isset($row['sent_by'], $row['message'], $row['date_envoi'])) {
                // Afficher les messages selon la logique de votre application
                if ($row['sent_by'] == $_SESSION['user']) {
                    ?>
                    <div class="message your_message">
                        <span>Vous</span>
                        <p><?= htmlspecialchars($row['message']) ?></p>
                        <p class="date"><?= $row['date_envoi'] ?></p>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="message others_message">
                        <span>Expéditeur: <?= htmlspecialchars($row['sent_by']) ?></span>
                        <p><?= htmlspecialchars($row['message']) ?></p>
                        <p class="date"><?= $row['date_envoi'] ?></p>
                    </div>
                    <?php
                }
            } else {
                // Gérer le cas où une clé nécessaire n'est pas définie
                echo "Données manquantes pour afficher le message.";
            }
        }
    }
} else {
    echo "Utilisateur non connecté";
}
?>
