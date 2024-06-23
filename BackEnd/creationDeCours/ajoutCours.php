<?php
session_start();

// Vérifier si id_user est défini dans la session
if (!isset($_SESSION['id_user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: ../FrontEnd/Pages/connexion.php');
    exit;
}

// Maintenant, $_SESSION['id_user'] est disponible pour être utilisé ici

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'] ?? '';
    $niveau = $_POST['niveau'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $id_user = $_SESSION['id_user']; // Utilisation de id_user depuis la session
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

    // Connexion à la base de données et insertion du cours
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=PA", "root", "root");
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête SQL pour insérer le cours avec l'image
        $sql = "INSERT INTO COURS (nom, niveau, prix, id_user, path_image_pres)
                VALUES (:nom, :niveau, :prix, :id_user, :path_image)";
        $stmt = $bdd->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':niveau', $niveau);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':id_user', $id_user);
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
