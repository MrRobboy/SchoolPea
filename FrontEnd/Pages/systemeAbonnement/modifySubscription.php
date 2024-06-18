<?php
session_start(); // Démarrer la session

require_once('config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}



// Récupérer les données du formulaire de modification d'abonnement
// (nouveau plan d'abonnement, etc.)

// Récupérer l'identifiant de l'abonnement existant du client depuis la base de données
$subscription_id = 'SUBSCRIPTION_ID';

// Mettre à jour l'abonnement du client avec le nouveau plan
\Stripe\Subscription::update(
    $subscription_id,
    ['items' => [['id' => 'SUBSCRIPTION_ITEM_ID', 'plan' => $_POST['new_plan_id']]]]
);

// Rediriger l'utilisateur vers une page de succès
header("Location: success_message.php");
?>
