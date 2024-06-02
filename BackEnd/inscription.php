<?php
$host = 'localhost';
$dbname = 'PA';
$username = 'root';
$password = 'root';
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, $options);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connexion Reussie ";

} catch (PDOException $e) {
    echo "Erreur Connexion" . $e->getMessage();
}

$error = false;
$passwordError = false;

// Vérifier si le formulaire d'inscription est soumis
if (isset($_POST['submit'])) {
    if (isset($_POST['name']) && strlen($_POST['name']) < 2) {
        $error = true;
    }

    if (isset($_POST['email']) && !preg_match("/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['email'])) {
        $error = true;
    }
    if (isset($_POST['password']) && !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['password'])) {
        $passwordError = true;
    }
}

if ($passwordError || $error) {
    // Vérifiez si le formulaire d'inscription est soumis
    if (isset($_POST['submit'])) {
        $location = 'Location: ../FrontEnd/Pages/inscription.php?';

        if ($passwordError) {
            $location .= 'password=0';
        }

        header($location);
    }
}

// Si le formulaire est soumis et aucune erreur n'est détectée, procédez à l'insertion des données dans la base de données
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Utilisez password_hash pour hacher le mot de passe
    $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "
    INSERT INTO USER (name, email, password)
    VALUES ($name, $email, $passwordHash);
    ";

    $queryStatement = $dbh->prepare($sql);

    $queryStatement->execute([
        "name" => $name,
        "email" => $email,
        "passwordHash" => $passwordHash // Utilisez la variable correcte pour le mot de passe haché
    ]);
}
