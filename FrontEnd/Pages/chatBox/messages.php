<?php
session_start();

// Inclure le fichier de connexion à la base de données PDO
require_once "connexion_bdd.php";

if (isset($_SESSION['user'])) {
    try {
        // Préparation de la requête SQL pour récupérer tous les messages avec les détails de l'utilisateur
        $stmt = $pdo->query("SELECT m.*, u.email FROM MESSAGE m JOIN USER u ON m.sent_by = u.id_user ORDER BY m.id_message DESC");

        // Vérification si des résultats sont retournés
        if ($stmt->rowCount() > 0) {
            // Récupérer tous les résultats en une seule fois
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                // Vérifier si toutes les clés nécessaires sont définies
                $requiredKeys = ['sent_by', 'message', 'date_envoi', 'email'];
                $missingKeys = [];

                foreach ($requiredKeys as $key) {
                    if (!isset($row[$key])) {
                        $missingKeys[] = $key;
                    }
                }

                if (empty($missingKeys)) {
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
                            <span>Expéditeur: <?= htmlspecialchars($row['email']) ?></span>
                            <p><?= htmlspecialchars($row['message']) ?></p>
                            <p class="date"><?= $row['date_envoi'] ?></p>
                        </div>
                        <?php
                    }
                } else {
                    // Afficher les clés manquantes
                    echo "Données manquantes pour afficher le message. Clés manquantes : " . implode(", ", $missingKeys) . "<br>";
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
