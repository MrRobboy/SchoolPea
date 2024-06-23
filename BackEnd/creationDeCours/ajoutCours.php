<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = $_POST['prix'];
    $createur = $_POST['createur'];
    $uploadFile = ''; // à définir après la gestion de l'upload

    // Gestion de l'upload de l'image
    if ($_FILES['courseImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/images/';
        $uploadFile = $uploadDir . basename($_FILES['courseImage']['name']);
        if (!move_uploaded_file($_FILES['courseImage']['tmp_name'], $uploadFile)) {
            echo "Erreur lors du téléchargement de l'image.";
            exit;
        }
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
        $sql = "INSERT INTO COURS (nom, niveau, prix, createur, path_image_pres)
                VALUES (:nom, :niveau, :prix, :createur, :path_image)";
        $stmt = $bdd->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':niveau', $niveau);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':createur', $createur);
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
