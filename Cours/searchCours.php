<?php
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try {
        $bdd = new PDO("mysql:host=localhost;dbname=PA", "root", "root", $options);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération des cours correspondant à la recherche
        $sql = "SELECT nom FROM COURS WHERE LOWER(nom) LIKE ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute(['%' . $query . '%']);

        $courses = $stmt->fetchAll();

        // Convert the results to JSON
        echo json_encode($courses);
    } catch (PDOException $e) {
        echo "Erreur Connexion : " . $e->getMessage();
        die;
    }
}
?>
