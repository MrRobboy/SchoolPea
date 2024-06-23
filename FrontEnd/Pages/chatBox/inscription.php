<?php
session_start();

if (isset($_SESSION['user'])) {
    // Si l'utilisateur est déjà connecté, le rediriger vers la page du chat
    header("location:chat.php");
    exit; // Assurez-vous de terminer le script après une redirection
}

require_once 'connexion_bdd.php'; // Utilisation de require_once pour inclure une seule fois

$error = '';

if (isset($_POST['button_inscription'])) {
    // Vérification des champs du formulaire
    if (!empty($_POST['email']) && !empty($_POST['mdp1']) && !empty($_POST['mdp2'])) {
        $email = $_POST['email'];
        $mdp1 = $_POST['mdp1'];
        $mdp2 = $_POST['mdp2'];

        if ($mdp1 !== $mdp2) {
            $error = "Les mots de passe ne correspondent pas !";
        } else {
            // Vérifier si l'email existe déjà
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() === 0) {
                // Insérer le nouvel utilisateur dans la base de données
                $hashed_password = password_hash($mdp1, PASSWORD_DEFAULT); // Hash du mot de passe
                $insert_stmt = $pdo->prepare("INSERT INTO utilisateurs (email, password) VALUES (?, ?)");
                $insert_stmt->execute([$email, $hashed_password]);

                // Redirection avec un message de succès vers la page de connexion
                $_SESSION['message'] = "<p class='message_inscription'>Votre compte a été créé avec succès !</p>";
                header("Location: index.php");
                exit;
            } else {
                $error = "Cet email est déjà utilisé !";
            }
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
    <title>Inscription | Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST" class="form_connexion_inscription">
        <h1>INSCRIPTION</h1>
        <p class="message_error"><?php echo $error; ?></p>
        <label>Adresse Mail</label>
        <input type="email" name="email" required>
        <label>Mot de passe</label>
        <input type="password" name="mdp1" class="mdp1" required>
        <label>Confirmation du mot de passe</label>
        <input type="password" name="mdp2" class="mdp2" required>
        <input type="submit" value="Inscription" name="button_inscription">
        <p class="link">Vous avez déjà un compte ? <a href="index.php">Se connecter</a></p>
    </form>
</body>
</html>
