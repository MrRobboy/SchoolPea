<?php
session_start(); // Démarrer la session

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = $_POST['prix'];

    // Récupération de l'ID du créateur (professeur) à partir de la session
    if (!isset($_SESSION['id_utilisateur'])) {
        echo "Erreur: Impossible de récupérer l'ID du professeur depuis la session.";
        exit;
    }
    $createur = $_SESSION['id_utilisateur']; // Utilisation directe de l'ID du professeur depuis la session

    // Gestion de l'upload de l'image
    $uploadDir = 'uploads/images/';
    $uploadFile = $uploadDir . basename($_FILES['courseImage']['name']);
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (!move_uploaded_file($_FILES['courseImage']['tmp_name'], $uploadFile)) {
        echo "Erreur lors du téléchargement de l'image.";
        exit;
    }

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "PA"; // Nom de votre base de données

    try {
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête SQL pour insérer le cours avec l'image
        $sql = "INSERT INTO cours (nom, niveau, prix, createur, path_image_pres)
                VALUES (:nom, :niveau, :prix, :createur, :path_image)";
        $stmt = $bdd->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':niveau', $niveau);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':createur', $createur, PDO::PARAM_INT); // Spécifier le type entier
        $stmt->bindParam(':path_image', $uploadFile);

        // Exécution de la requête
        $stmt->execute();

        echo "Le cours a été ajouté avec succès.";
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
