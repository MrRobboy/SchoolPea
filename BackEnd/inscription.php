<?php
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $bdd = new PDO("mysql:host=localhost;dbaname=PA", "root", "root");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion Reussie<br> ";
} catch (PDOException $e) {
    echo "Erreur Connexion " . $e->getMessage();
    die;
}


if (isset($_POST['submit_inscription'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email_inscription']);
    $password = htmlspecialchars($_POST['password_inscription']);

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    echo ('INFOS :<br>Name : ' . $name . '<br>Mail : ' . $email . '<br>Password : ' . $password . '<br>Password Hash : ' . $passwordHash);

    $queryStatement = $bdd->prepare('USE PA; INSERT INTO USER(name, email, password) VALUES (:name, :email, :password);');

    $queryStatement->bindvalue(':name', $name);
    $queryStatement->bindvalue(':email', $email);
    $queryStatement->bindvalue(':password', $passwordHash);

    $result = $queryStatement->execute();

    if (isset($result) && !$result) {
        echo "<br><br>ECHEC INJECTION";
        header('Location: ../FrontEnd/Pages/compte.php');
    } else {
        echo "<br><br> REUSSITE INJECTION";
    }
}
