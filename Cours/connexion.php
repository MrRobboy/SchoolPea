<?php
session_start();
$badCredentials = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['password_connexion']) || !isset($_POST['email_connexion'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit(); 
    }

    $pass = htmlspecialchars($_POST['password_connexion']);
    $email = htmlspecialchars($_POST['email_connexion']);

    include('db.php');

    if ($dbh === null) {
        die("La connexion à la base de données a échoué.");
    }

    try {
        $requestDB = 'SELECT * FROM USER WHERE email = :email';
        $stmt = $dbh->prepare($requestDB);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
        exit(); 
    }

    if (!empty($user) && $user['validation_mail'] == 1) {
        if (password_verify($pass, $user['pass'])) {
            $_SESSION['id_user'] = htmlspecialchars($user['id_USER']);
            $_SESSION['email'] = htmlspecialchars($user['email']);
            $_SESSION['firstname'] = htmlspecialchars($user['firstname']);
            $_SESSION['lastname'] = htmlspecialchars($user['lastname']);
            $_SESSION['path_pp'] = htmlspecialchars($user['path_pp']);
            $_SESSION['elo'] = htmlspecialchars($user['elo']);
            $_SESSION['role'] = htmlspecialchars($user['role']);
            $_SESSION['mail_valide'] = htmlspecialchars($user['validation_mail']);

            $message = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' s\'est connecté';
            $queryLogs = $dbh->prepare('INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg);');
            $queryLogs->bindValue(':id_USER', $user['id_USER'], PDO::PARAM_INT);
            $queryLogs->bindValue(':msg', $message, PDO::PARAM_STR);
            $result = $queryLogs->execute();

            if ($result) {
                header('Location: https://schoolpea.com/Cours/creerCours.php');
                exit(); 
            } else {
                echo 'Erreur lors de l\'enregistrement de l\'action dans les logs.';
            }
        } else {
            $badCredentials = true;
        }
    } else {
        echo 'Mail non validé !!!!';
    }

    
    if ($badCredentials) {
        echo "Invalid email or password.";
    }
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit(); 
}
?>
