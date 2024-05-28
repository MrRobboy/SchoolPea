<?php
session_start();

// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pa";

// Vérifier si des données ont été envoyées via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupération des données du formulaire et échappement
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $mdp = mysqli_real_escape_string($conn, $_POST['mdp']);

    // Requête SQL sécurisée
    $sql = "SELECT * FROM USER WHERE login='$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Utilisateur trouvé, vérification du mot de passe
        $row = $result->fetch_assoc();
        if (password_verify($mdp, $row['mdp'])) {
            // Mot de passe correct, connexion réussie
            $_SESSION['login'] = $login;

            // Enregistrement du log
            $action = "Connexion de l'utilisateur : $login";
            $action_escaped = mysqli_real_escape_string($conn, $action); // Échappement de la valeur de l'action
            $sql_log = "INSERT INTO Logs (id_utilisateur, action) VALUES ('$login', '$action_escaped')";
            $conn->query($sql_log);

            echo "Connexion réussie";
        } else {
            echo "Mot de passe ou identifiant incorrect";
        }
    } 

    // Fermer la connexion à la base de données
    $conn->close();
}
    // Si aucune donnée n'a été envoyée via POST, afficher un message d'erreur
?>
