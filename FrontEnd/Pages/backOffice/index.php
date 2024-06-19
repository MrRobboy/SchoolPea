<?php
include 'includes/auth.php';
include 'templates/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - Tableau de Bord</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Tableau de Bord</h1>
        <div class="dashboard">
            <div class="dashboard-item">
                <a href="users.php">
                    <h2>Gestion des Utilisateurs</h2>
                    <p>Ajouter, modifier ou supprimer des utilisateurs</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="content.php">
                    <h2>Gestion du Contenu</h2>
                    <p>Ajouter, modifier ou supprimer du contenu</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="logs.php">
                    <h2>Visualisation des Logs</h2>
                    <p>Consulter les logs des activités</p>
                </a>
            </div>
            <div class="dashboard-item">
                <a href="roles.php">
                    <h2>Gestion des Rôles</h2>
                    <p>Ajouter, modifier ou supprimer des rôles d'utilisateur</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

<?php include 'templates/footer.php'; ?>
