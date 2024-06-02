<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    echo "Utilisateur non connecté.";
    exit;
}


$user_id = $_SESSION['user_id'];

// Connexion à la base de données avec PDO
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Activer les exceptions PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les informations utilisateur
    $sql = "SELECT nom, email, password, role, id FROM utilisateurs WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Récupération des données utilisateur
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nom = $row["nom"];
        $email = $row["email"];
        $password = $row["password"];
        $role = $row["role"];
        $id = $row["id"];
    } else {
        echo "Aucun utilisateur trouvé avec cet ID.";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

// Fermer la connexion à la base de données
$conn = null;
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Utilisateur</title>
    <!-- Inclure la bibliothèque jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>
    <h1>Profil Utilisateur</h1>
    <p>Nom: <?php echo $nom; ?></p>
    <p>Email: <?php echo $email; ?></p>
    <p>Mot de passe: <?php echo $motDePasse; ?></p>
    <p>Rôle: <?php echo $role; ?></p>
    <p>ID: <?php echo $id; ?></p>

    <!-- Bouton pour exporter en PDF -->
    <button onclick="generatePDF()">Exporter en PDF</button>
</body>

</html>


<script>
    function generatePDF() {
        // Créer un nouveau document PDF
        var doc = new jsPDF();

        // Ajouter les informations utilisateur au PDF
        doc.text("Nom: <?php echo $nom; ?>", 10, 20);
        doc.text("Email: <?php echo $email; ?>", 10, 30);
        doc.text("Mot de passe: <?php echo $password; ?>", 10, 40);
        doc.text("Rôle: <?php echo $role; ?>", 10, 50);
        doc.text("ID: <?php echo $id; ?>", 10, 60);

        // Télécharge le PDF
        doc.save("monProfil.pdf");
    }
</script>