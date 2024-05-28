<?php
// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root"; // Utilisateur MySQL
$password = "root";
$dbname = "PA"; // Nom de la base de données

// Vérifier si des données ont été envoyées via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    // Hasher le mot de passe
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    // Connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Requête pour insérer les données dans la base de données
    $sql = "INSERT INTO USER (nom_user, prenom_user, mail, login, mdp) VALUES ('$nom', '$prenom', '$mail', '$login', '$mdp_hash')";

    if ($conn->query($sql) === TRUE) {
        // Insertion réussie, maintenant enregistrons cette action dans les logs
        $action = "Nouvel utilisateur créé : $nom $prenom ($login)";
        $sql_log = "INSERT INTO Logs (id_utilisateur, action) VALUES ('$login', '$action')";
        
        if ($conn->query($sql_log) === TRUE) {
            echo "Inscription réussie !";
        } else {
            echo "Erreur lors de l'enregistrement du log : " . $conn->error;
        }
    } else {
        echo "Erreur lors de l'inscription : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    // Si aucune donnée n'a été envoyée via POST, afficher un message d'erreur
    echo "Erreur : Aucune donnée reçue.";
}
?>
