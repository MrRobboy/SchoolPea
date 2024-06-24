<?php
session_start();

if (isset($_SESSION['user'])) {
    // Si l'utilisateur est déjà connecté, le rediriger vers la page du chat
    header("location:chat.php");
    exit;
}

require_once 'connexion_bdd.php';

$error = '';

if (isset($_POST['button_connexion'])) {
    // Vérification des champs du formulaire
    if (!empty($_POST['email']) && !empty($_POST['mdp'])) {
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        // Requête préparée pour récupérer l'utilisateur par son email
        $stmt = $pdo->prepare("SELECT * FROM USER WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($mdp, $user['password'])) {
            // Si le mot de passe correspond, connecter l'utilisateur
            $_SESSION['user'] = $user['email'];
            header("location:chat.php");
            exit;
        } else {
            $error = "Identifiants incorrects !";
        }
    } else {
        $error = "Veuillez remplir tous les champs !";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Chat</title>
    <link rel="stylesheet" type="text/css" href="chat.css">
</head>

<body>
    <form action="" method="POST" class="form_connexion_inscription">
        <h1>CONNEXION</h1>
        <p class="message_error"><?php echo $error; ?></p>
        <label>Adresse Mail</label>
        <input type="email" name="email" required>
        <label>Mot de passe</label>
        <input type="password" name="mdp" required>
        <input type="submit" value="Connexion" name="button_connexion">
        <p class="link">Vous n'avez pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
    </form>
</body>

</html>