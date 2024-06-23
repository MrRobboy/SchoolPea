<?php
$dsn = 'mysql:host=localhost;dbname=PA;charset=utf8mb4';
$username = 'root';
$password = 'root';

// Create a new PDO instance
try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer les exceptions PDO
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Désactiver l'émulation des requêtes préparées
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Requête SQL pour récupérer le classement des utilisateurs par Elo et moyenne
$sql = "SELECT firstname AS Nom, lastname AS Prenom, elo AS Elo, 0 AS Moyenne FROM USER ORDER BY elo DESC";
$result = $dbh->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des Utilisateurs</title>
    <link rel="stylesheet" href="classement.css">
</head>
<body>
    <?php
    session_start();
    $path = $_SERVER['DOCUMENT_ROOT'];
    if (isset($_SESSION['id'])) {
        if ($_SESSION['admin'])
            $path .= '/headerA.php';
        else
            $path .= '/headerL.php';
    } else {
        $path .= '/headerNL.php';
    }
    include_once($path);
    ?><!-- header -->

    <h1>Classement des Utilisateurs</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Elo</th>
                <th>Moyenne</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->rowCount() > 0) {
                $counter = 1;
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $counter . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nom']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Prenom']) . "</td>";
                    echo "<td>" . $row['Elo'] . "</td>";
                    echo "<td>" . $row['Moyenne'] . "</td>";
                    echo "</tr>";
                    $counter++;
                }
            } else {
                echo "<tr><td colspan='5'>Aucun utilisateur trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$dbh = null;
?>
