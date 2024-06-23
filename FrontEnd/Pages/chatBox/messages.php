<?php
session_start();

// Inclure le fichier de connexion à la base de données PDO
require_once "connexion_bdd.php";

if (isset($_SESSION['user'])) {
    try {
        // Préparation de la requête SQL pour récupérer les messages avec les détails de l'utilisateur
        // Assurez-vous de remplacer `sent_by` par le nom correct de la colonne dans votre base de données
        $stmt = $pdo->prepare("SELECT * FROM MESSAGE WHERE sent_by = ? ORDER BY id_message DESC");
        $stmt->execute([$_SESSION['user']]);

        // Vérification si des résultats sont retournés
        if ($stmt->rowCount() > 0) {
            // Récupérer tous les résultats en une seule fois
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                ?>
                <div class="message">
                    <?php if ($row['sent_by'] == $_SESSION['user']) : ?>
                        <span>Vous</span>
                    <?php else : ?>
                        <span>Expéditeur: <?= htmlspecialchars($row['sent_by']) ?></span>
                    <?php endif; ?>
                    <p><?= htmlspecialchars($row['message']) ?></p>
                    <p class="date"><?= $row['date_envoi'] ?></p>
                </div>
                <?php
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
