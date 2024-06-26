<?php
session_start();
$badCredentials = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification des champs requis
    if (!isset($_POST['password_connexion']) || !isset($_POST['email_connexion'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Récupération des données du formulaire
    $pass = htmlspecialchars($_POST['password_connexion']);
    $email = htmlspecialchars($_POST['email_connexion']);

    // Connexion à la base de données
    include('db.php');

    // Requête pour récupérer les informations de l'utilisateur par email
    $requestDB = 'SELECT * FROM USER WHERE email = :email';
    $stmt = $dbh->prepare($requestDB);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll();

    if (!empty($user) && $user[0]['validation_mail'] == 1) {
        // Vérification du mot de passe avec password_verify()
        if (password_verify($pass, $user[0]['pass'])) {
            // Initialisation des variables de session
            $_SESSION['id_user'] = htmlspecialchars($user[0]['id_USER']);
            $_SESSION['email'] = htmlspecialchars($user[0]['email']);
            $_SESSION['firstname'] = htmlspecialchars($user[0]['firstname']);
            $_SESSION['lastname'] = htmlspecialchars($user[0]['lastname']);
            $_SESSION['path_pp'] = htmlspecialchars($user[0]['path_pp']);
            $_SESSION['elo'] = htmlspecialchars($user[0]['elo']);
            $_SESSION['role'] = htmlspecialchars($user[0]['role']);
            $_SESSION['mail_valide'] = htmlspecialchars($user[0]['validation_mail']);

            // Enregistrement de la connexion dans les logs
            $message = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' s\'est connecté';
            $queryLogs = $dbh->prepare('INSERT INTO LOGS (id_user, act) VALUES (:id_USER, :msg)');
            $queryLogs->bindValue(':id_USER', $user[0]['id_USER'], PDO::PARAM_INT);
            $queryLogs->bindValue(':msg', $message, PDO::PARAM_STR);
            $result = $queryLogs->execute();

            if ($result) {
                // Redirection vers la création de cours
                header('Location: creerCours.php');
                exit();
            } else {
                echo "Erreur lors de l'enregistrement dans les logs.";
            }
        } else {
            $badCredentials = true;
        }
    } else {
        echo "L'adresse email n'est pas validée.";
    }
}

// Suppression des données de session restantes
session_unset();
?>
