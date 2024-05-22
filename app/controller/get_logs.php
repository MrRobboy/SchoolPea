<?php
// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root";
$password = ""; // Mot de passe vide si tu te connectes en tant que root
$dbname = "pa"; // Nom de la base de données


$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Requête pour récupérer les logs
$sql = "SELECT * FROM Logs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Afficher les logs dans un tableau HTML
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id_log"] . "</td><td>" . $row["id_utilisateur"] . "</td><td>" . $row["action"] . "</td><td>" . $row["timestamp"] . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='4'>Aucun log trouvé</td></tr>";
}

$conn->close();
?>
