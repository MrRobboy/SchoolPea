<?php
session_start(); // Démarrer la session

require_once('config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}

// Récupérer l'identifiant de l'abonnement existant du client depuis la base de données
$subscription_id = 'SUBSCRIPTION_ID';

// Annuler l'abonnement du client
\Stripe\Subscription::retrieve($subscription_id)->cancel();

// Rediriger l'utilisateur vers une page de succès
header("Location: success_message.php");
?>
