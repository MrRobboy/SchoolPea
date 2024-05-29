<?php
session_start();

// Database connection
$cbdd = 'ysql:host=localhost;dbname=PA;charset=utf-8';
$username = 'root';
$password = 'root';

try {
    $bdd = new PDO($cbdd, $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : '. $e->getMessage();
    exit();
}

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($name) &&!empty($email) &&!empty($password)) {
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $password = password_hash($password, PASSWORD_DEFAULT);

        $insertUser = $bdd->prepare('INSERT INTO USER (nom_user, mail, mdp) VALUES (:name, :email, :password)');
        $insertUser->execute([':name' => $name, ':email' => $email, ':password' => $password]);

        $recupUser = $bdd->prepare('SELECT * FROM USER WHERE mail = :email AND mdp = :password');
        $recupUser->execute([':email' => $email, ':password' => $password]);

        if ($recupUser->rowCount() > 0) {
            $user = $recupUser->fetch();
            $_SESSION['mail'] = $email;
            $_SESSION['id'] = $user['id'];
            // Do not store the password in the session
            // $_SESSION['mdp'] = $password;
        } else {
            echo "Veuillez completer tous les champs...";
        }
    } else {
        echo "Veuillez completer tous les champs...";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Inscription | SchoolPéa</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />
</head>

<body>
    <div class="container Inscription" id="Conteneur">
        <div class="form-container sign-in">
            <form action="./accueil_nl.php" method="post">
                <h1>Connexion</h1>
                <input type="email" id="email" name="email" placeholder="Email" />
                <input type="password" id="password" name="password" placeholder="Mot de passe" />
                <a href="#">Mot de passe oublié ?</a>
                <button type="submit">Connexion</button>
            </form>
        </div>

        <div class="form-container sign-up">
            <form action="./accueil_nl.php" method="post">
                <h1 style="text-align: center">Bienvenue chez SchoolPéa</h1>
                <input type="text" id="name" name="name" placeholder="Name" />
                <input type="email" id="email" name="email" placeholder="Email" />
                <input type="password" id="password" name="password" placeholder="Mot de passe" />
                <p><?php if (isset($_GET['password']) && $_GET['password'] === '0') { echo('Mauvais mdp'); } ?></p>
                <button type="submit">Inscription</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Te revoila !</h1>
                    <button class="hidden" id="Connexion">Connexion</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>T'es nouveau ?</h1>
                    <button class="hidden" id="Inscription">Inscription</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>
