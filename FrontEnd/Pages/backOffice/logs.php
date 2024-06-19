<?php
include 'includes/auth.php';
include 'templates/header.php';
include 'includes/get_logs.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Visualisation des Logs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Logs</th>
                    <th>ID Utilisateur</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($logs)) {
                    foreach ($logs as $log) {
                        echo "<tr>
                            <td>" . htmlspecialchars($log['id_log']) . "</td>
                            <td>" . htmlspecialchars($log['id_utilisateur']) . "</td>
                            <td>" . htmlspecialchars($log['action']) . "</td>
                            <td>" . htmlspecialchars($log['timestamp']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun log trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php include 'templates/footer.php'; ?>
