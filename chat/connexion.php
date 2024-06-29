<?php
session_start();
$badCredentials = false;

// Vérifier si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si les clés password_connexion et email_connexion existent dans $_POST
    if (!isset($_POST['password_connexion']) || !isset($_POST['email_connexion'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit(); // Arrêter le script si les clés ne sont pas définies
    }

    // Récupérer les valeurs postées
    $pass = htmlspecialchars($_POST['password_connexion']);
    $email = htmlspecialchars($_POST['email_connexion']);

    // Inclure le fichier de connexion à la base de données
    include('db.php');

    // Vérifier la connexion à la base de données
    if ($dbh === null) {
        die("La connexion à la base de données a échoué.");
    }

    try {
        // Préparer la requête SQL pour récupérer l'utilisateur par email
        $requestDB = 'SELECT * FROM USER WHERE email = :email';
        $stmt = $dbh->prepare($requestDB);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Utiliser fetch pour récupérer une seule ligne
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
        exit(); // Arrêter le script en cas d'erreur PDO
    }

    // Vérifier si l'utilisateur existe et si son email est validé
    if (!empty($user) && $user['validation_mail'] == 1) {
        // Vérifier si le mot de passe correspond
        if (password_verify($pass, $user['pass'])) {
            // Stocker les informations de l'utilisateur en session
            $_SESSION['id_user'] = htmlspecialchars($user['id_USER']);
            $_SESSION['email'] = htmlspecialchars($user['email']);
            $_SESSION['firstname'] = htmlspecialchars($user['firstname']);
            $_SESSION['lastname'] = htmlspecialchars($user['lastname']);
            $_SESSION['path_pp'] = htmlspecialchars($user['path_pp']);
            $_SESSION['elo'] = htmlspecialchars($user['elo']);
            $_SESSION['role'] = htmlspecialchars($user['role']);
            $_SESSION['mail_valide'] = htmlspecialchars($user['validation_mail']);

            // Enregistrer une action de connexion dans les logs
            $message = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' s\'est connecté';
            $queryLogs = $dbh->prepare('INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg);');
            $queryLogs->bindValue(':id_USER', $user['id_USER'], PDO::PARAM_INT);
            $queryLogs->bindValue(':msg', $message, PDO::PARAM_STR);
            $result = $queryLogs->execute();

            
            if ($result) {
                header('Location: https://schoolpea.com/chat/index.php');
                exit(); // Arrêter le script après la redirection
            } else {
                echo 'Erreur lors de l\'enregistrement de l\'action dans les logs.';
            }
        } else {
            $badCredentials = true;
        }
    } else {
        echo 'Mail non validé !!!!';
    }

    // Afficher un message d'erreur si les identifiants sont invalides
    if ($badCredentials) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        echo "Invalid email or password.";
    }
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit(); // Redirection si la méthode de requête n'est pas POST
}
?>
