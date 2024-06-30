<?php
session_start();

// Informations de connexion à la base de données
$host = 'localhost'; // Adresse du serveur de base de données
$dbname = 'PA'; // Nom de la base de données
$username = 'username'; // Nom d'utilisateur
$password = 'password'; // Mot de passe

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Configuration de PDO pour lancer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations d'identification
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer la requête pour récupérer l'utilisateur
    $sql = "SELECT id_USER, pass FROM USER WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier le mot de passe
    if ($user && password_verify($password, $user['pass'])) {
        // Connexion réussie
        $_SESSION['user_id'] = $user['id_USER'];
        header("Location: index.php");
        exit();
    } else {
        // Connexion échouée
        echo 'Identifiants incorrects. <a href="login.php">Réessayer</a>';
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermer la connexion PDO
$pdo = null;
?>
