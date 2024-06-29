<?php
$host = 'localhost';
$dbname = 'PA';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les messages depuis la table MESSAGE, avec les informations de l'utilisateur
    $stmt = $dbh->query("SELECT m.message, u.email FROM MESSAGE m INNER JOIN USER u ON m.sent_by = u.id_USER ORDER BY m.id_MESSAGE DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($messages);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la récupération des messages : ' . $e->getMessage()]);
}
?>
