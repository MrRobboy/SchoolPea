<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = $_POST['prix'];
    $createur = $_POST['createur'];
    
    // Gestion de l'upload de l'image
    $uploadDir = 'uploads/images/';
    $uploadFile = $uploadDir . basename($_FILES['courseImage']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image réelle
    $check = getimagesize($_FILES['courseImage']['tmp_name']);
    if ($check === false) {
        echo "Le fichier n'est pas une image valide.";
        exit;
    }

    // Vérifier la taille du fichier (5 Mo maximum)
    if ($_FILES['courseImage']['size'] > 5000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        exit;
    }

    // Vérifier le type de fichier
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        exit;
    }

    // Assurez-vous que le répertoire d'upload existe
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Déplacer le fichier téléchargé vers le répertoire d'upload
    if (move_uploaded_file($_FILES['courseImage']['tmp_name'], $uploadFile)) {
        echo "L'image a été téléchargée avec succès.";

        // Ici, vous pouvez enregistrer le chemin de l'image dans votre base de données
        // Exemple de connexion à la base de données (à adapter selon votre configuration)
        $servername = "localhost";
        $username = "root";
        $password = "mot_de_passe";
        $dbname = "nom_de_la_base_de_donnees";

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
            $stmt->bindParam(':createur', $createur);
            $stmt->bindParam(':path_image', $uploadFile);

            // Exécution de la requête
            $stmt->execute();

            echo "Le cours a été ajouté avec succès.";
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
