<?php
session_start(); // Démarrer la session

require_once('config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - SchoolPea+</title>
</head>
<body>
    <h1>Tableau de bord - SchoolPea+</h1>
    <p>Bienvenue, <?php echo $_SESSION['username']; ?>!</p>
    <ul>
        <li><a href="subscribe.php">Souscrire à un abonnement</a></li>
        <li><a href="modify_subscription.php">Modifier mon abonnement</a></li>
        <li><a href="cancel_subscription.php">Annuler mon abonnement</a></li>
    </ul>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
