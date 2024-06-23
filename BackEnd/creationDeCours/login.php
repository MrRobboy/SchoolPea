<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "root";
    $dbname = "PA";

    try {
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérification des identifiants
        $stmt = $bdd->prepare("SELECT id_user, role FROM user WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['id_utilisateur'] = $user['id_user'];
            $_SESSION['role'] = $user['role'];

            // Redirection vers la page d'accueil ou une autre page
            header("Location: index.php");
            exit;
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
?>
