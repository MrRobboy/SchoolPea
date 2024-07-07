<?php
session_start();

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

$sql = "SELECT lastname AS Nom, firstname AS Prenom, elo AS Elo, 0 AS Moyenne FROM USER ORDER BY elo DESC";
$result = $dbh->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des Utilisateurs</title>
    <link rel="stylesheet" type="text/css" href="./classement.css">
</head>

<body>
    <?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    if (isset($_SESSION['mail_valide'])) {
        $path .= '/headerL.php';
    } else {
        $path .= '/headerNL.php';
    }
    include($path);
    ?>

    <div id="content">
        <h1>Classement des Utilisateurs</h1>
        <div id="table-container">
            <table id="classement">
                <thead>
                    <tr>
                        <th style="padding: 0 0.5rem;border-right: solid 0.3rem white;">Rang</th>
                        <th style="padding: 0 7rem;border-right: solid 0.3rem white;">Nom</th>
                        <th style="padding: 0 5rem;border-right: solid 0.3rem white;">Prenom</th>
                        <th style="padding: 0 3rem;border-right: solid 0.3rem white;">Elo</th>
                        <th style="padding: 0 3rem;border-right: none;">Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->rowCount() > 0) {
                        $counter = 1;
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td class="not_right">' . $counter . '</td>';
                            echo '<td class="not_right">' . htmlspecialchars($row['Nom']) . '</td>';
                            echo '<td class="not_right">' . htmlspecialchars($row['Prenom']) . '</td>';
                            echo '<td class="not_right">' . $row['Elo'] . '</td>';
                            echo '<td>' . $row['Moyenne'] . '</td>';
                            echo '</tr>';
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>Aucun utilisateur trouvé</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php

$dbh = null;
?>