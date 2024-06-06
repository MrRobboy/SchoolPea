<?php
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $bdd = new PDO("mysql:host=localhost;dbaname=PA","root","root");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion Reussie<br> ";
} catch (PDOException $e) {
	echo "Erreur Connexion " . $e->getMessage();
	die;
}
/*
$error = false;
$passwordError = false;

// Vérifier si le formulaire d'inscription est soumis
if (isset($_POST['submit_inscription'])) {
    if (isset($_POST['name']) && strlen($_POST['name']) < 2) {
        $error = true;
    }

    if (isset($_POST['email_inscription']) && !preg_match("/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['email_inscription'])) {
        $error = true;
    }
    if (isset($_POST['password_inscription']) && !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['password_inscription'])) {
        $passwordError = true;
    }
}

if ($passwordError || $error) {
    // Vérifiez si le formulaire d'inscription est soumis
    if (isset($_POST['submit_inscr'])) {//volontairement laissé mal saisi pour accéder à la page de back end ;)
        $location = 'Location: ../FrontEnd/Pages/inscription.php?';

        if ($passwordError) {
            $location .= 'password=0';
        }

        header($location);
    }
}
 */

if (isset($_POST['submit_inscription'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email_inscription']);
    $password = htmlspecialchars($_POST['password_inscription']);

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    echo ('INFOS :<br>Name : ' . $name . '<br>Mail : ' . $email . '<br>Password : ' . $password . '<br>Password Hash : ' . $passwordHash);

    $queryStatement = $bdd->prepare('INSERT INTO USER(name, email, password) VALUES (:name, :email, :password);');

    $queryStatement->bindvalue(':name', $name);
    $queryStatement->bindvalue(':email', $email);
    $queryStatement->bindvalue(':password', $passwordHash);

    $result = $queryStatement->execute();

    if (isset($result) && !$result) {
        echo "<br><br>ECHEC INJECTION";
    } else {
	echo "<br><br> REUSSITE INJECTION";
    
    }
}
