<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];
    $prix = $_POST['prix'];
    $createur = $_POST['createur'];
    $contenu = $_POST['contenu'];


    // Connexion à la base de données

$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $bdd = new PDO("mysql:host=localhost;dbaname=PA","root","root");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion Reussie <br> ";
} catch (PDOException $e) {
	echo "Erreur Connexion " . $e->getMessage();
	die;
}
        // Préparation de la requête SQL pour insérer le cours
        $sql = "INSERT INTO cours (nom, niveau, prix, createur, contenu) VALUES (:nom, :niveau, :prix, :createur, :contenu)";
$stmt = $bdd->prepare($sql);


        // Liaison des paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':niveau', $niveau);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':createur', $createur);
        $stmt->bindParam(':contenu', $contenu);

        // Exécution de la requête
        $stmt->execute();

        // Redirection vers la page d'accueil ou une autre page après l'ajout du cours
        header("Location: index.php");
        exit;
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }

} else {
    // Redirection vers la page de formulaire si le formulaire n'a pas été soumis
    header("Location: formulaire_cours.php");
    exit;
}
?>
