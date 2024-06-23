<?php
session_start();

// Inclure le fichier de connexion à la base de données PDO
require_once "connexion_bdd.php";

if (isset($_SESSION['user'])) {
    try {
        // Préparation de la requête SQL pour récupérer les messages avec les détails de l'utilisateur
        $stmt = $pdo->query("SELECT * FROM MESSAGE ORDER BY id_message DESC");

        // Vérification si des résultats sont retournés
        if ($stmt->rowCount() > 0) {
            // Récupérer tous les résultats en une seule fois
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
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
            
        } else {
            echo "Aucun message trouvé.";
        }
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }
} else {
    echo "Utilisateur non connecté.";
}
?>
