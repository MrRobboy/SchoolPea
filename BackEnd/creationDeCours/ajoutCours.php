<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = $_POST['prix'];
    $createur = $_POST['createur'];
    
    // Récupération des sections
    $sections = [];
    foreach ($_POST['sectionTitle'] as $index => $title) {
        $sections[] = [
            'title' => $title,
            'content' => $_POST['sectionContent'][$index]
        ];
    }

    // Conversion des sections en JSON pour les stocker dans un fichier séparé
    $contenu = json_encode($sections);

    // Gestion de l'image
    if (isset($_FILES['courseImage']) && $_FILES['courseImage']['error'] == 0) {
        $target_dir = "uploads/images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Créer le répertoire si inexistant
        }
        $imageFileType = strtolower(pathinfo(basename($_FILES["courseImage"]["name"]), PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid() . '.' . $imageFileType;
        
        if (move_uploaded_file($_FILES["courseImage"]["tmp_name"], $target_file)) {
            $imagePath = $target_file; // Chemin de l'image à stocker dans la BDD
        } else {
            echo "Erreur lors du téléchargement de l'image.";
            exit;
        }
    } else {
        $imagePath = null; // Pas d'image téléchargée
    }

    // Gestion du fichier de contenu
    $content_dir = "uploads/contents/";
    if (!is_dir($content_dir)) {
        mkdir($content_dir, 0777, true); // Créer le répertoire si inexistant
    }
    $content_file = $content_dir . uniqid() . '.json';
    
    if (file_put_contents($content_file, $contenu) === false) {
        echo "Erreur lors de l'enregistrement du contenu.";
        exit;
    }

    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try {
        $bdd = new PDO("mysql:host=localhost;dbname=PA", "root", "root", $options);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur Connexion: " . $e->getMessage();
        die;
    }

    $sql = "INSERT INTO COURS (nom, niveau, prix, createur, path_contenu, path_image_pres) VALUES (:nom, :niveau, :prix, :createur, :path_contenu, :path_image_pres)";
    $stmt = $bdd->prepare($sql);
    try {
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':niveau', $niveau);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':createur', $createur);
        $stmt->bindParam(':path_contenu', $content_file); // Chemin du fichier de contenu
        $stmt->bindParam(':path_image_pres', $imagePath);

        $stmt->execute();
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    echo "Formulaire non soumis.";
    exit;
}
?>
