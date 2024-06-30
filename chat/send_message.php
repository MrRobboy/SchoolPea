<?php
session_start();

// Vérification de l'existence de la session utilisateur
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php"); // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

include 'db.php'; // Inclusion du fichier de connexion à la base de données

// Récupération de l'ID utilisateur depuis la session
$id_user = $_SESSION['id_user'];

try {
    // Vérification si l'utilisateur existe dans la table USER
    $stmt = $dbh->prepare("SELECT id_USER FROM USER WHERE id_USER = :id_user");
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        echo "Utilisateur avec ID " . $id_user . " non trouvé dans la base de données USER.";
        exit(); // Arrêt de l'exécution si l'utilisateur n'existe pas
    }
} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage();
    // En pratique, vous devriez logger cette erreur plutôt que de l'afficher directement
}

// Traitement du formulaire de création de message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $users_id = $_SESSION['id_user']; // Utiliser l'ID utilisateur de la session
    

    // Début de la transaction
    $dbh->beginTransaction();

    try {
        // Insérer le message dans la table messages
        $sql_insert_message = "INSERT INTO messages (message, users_id, description)
                               VALUES (:message, :users_id, :description)";
        $stmt_insert_message = $dbh->prepare($sql_insert_message);
        $stmt_insert_message->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt_insert_message->bindValue(':users_id', $users_id, PDO::PARAM_INT);
        
        
        $stmt_insert_message->execute();
        
        // Valider la transaction
        $dbh->commit();


        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, annuler la transaction
        $dbh->rollBack();
        echo "Erreur lors de l'insertion du message : " . $e->getMessage();
        // En pratique, vous devriez logger cette erreur plutôt que de l'afficher directement
    }
}
?>
