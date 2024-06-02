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
	if (isset($_POST['submit_inscr'])){/*volontairement laissé mal saisi pour accéder à la page de back end ;)*/
        $location = 'Location: ../FrontEnd/Pages/inscription.php?';

        if ($passwordError) {
            $location .= 'password=0';
        }

        header($location);
    }
}

// Si le formulaire est soumis et aucune erreur n'est détectée, procédez à l'insertion des données dans la base de données
if (isset($_POST['submit_inscription'])) {
    $name = $_POST['name'];
    $email = $_POST['email_inscription'];
    $password = $_POST['password_inscription'];

    // Utilisez password_hash pour hacher le mot de passe
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    echo ('INFOS :<br>Name : ' . $name . '<br>Mail : ' . $email . '<br>Password : ' . $password.'<br>Password Hash : '. $passwordHash);

    $sql = "
    INSERT INTO USER (name, email, password)
    VALUES ($name, $email, $passwordHash);
    ";
    echo '<br> REUSSITE INJECTION';

    $queryStatement = $dbh->prepare($sql);

    $queryStatement->execute(/*[
        "name" => $name,
        "email" => $email,
        "passwordHash" => $passwordHash // Utilisez la variable correcte pour le mot de passe haché
    ]*/);
}
