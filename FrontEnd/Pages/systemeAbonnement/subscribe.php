<?php
session_start(); // Démarrer la session

require_once('config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}

// Récupérer les données du formulaire de souscription
// (nom, email, plan d'abonnement, etc.)

// Créer un client Stripe
$customer = \Stripe\Customer::create([
    'email' => $_POST['email'],
    'source'  => $_POST['stripeToken']
]);

// Souscrire le client à un plan d'abonnement
$subscription = \Stripe\Subscription::create([
    'customer' => $customer->id,
    'items' => [['plan' => $_POST['plan_id']]],
]);

// Rediriger l'utilisateur vers une page de succès
header("Location: success_message.php");
?>
