<?php
session_start();
require_once './db.php';
/* A SETUP !
$request = $dbh->query('SELECT * FROM USER WHERE email = :email;');
$queryStatement->bindvalue(':email', $_SESSION['email']);
$infos = $request->fetchAll();
$_SESSION['path_pp'] = $infos[0]['path_pp']; */

$badCredentials = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the password and email keys exist in the $_POST array
    if (!isset($_POST['password_connexion']) || !isset($_POST['email_connexion'])) {
        echo "Email or password not set.";
        exit;
    }

    $password = $_POST['password_connexion'];
    $email = $_POST['email_connexion'];

    // Prepare the SQL statement
    $getUserSql = "USE PA; SELECT * FROM USER WHERE email = :email";

    if ($dbh) {
        $preparedGetUserSql = $dbh->prepare($getUserSql);
        $preparedGetUserSql->execute(['email' => $email]);
        $user = $preparedGetUserSql->fetch();

        if ($user) {
            if (password_verify($password, $user[0]['password'])) {
                $_SESSION['idUser'] = $user[0]['id_user'];
                $_SESSION['firstname'] = $user[0]['firstname'];
                $_SESSION['lastname'] = $user[0]['lastname'];
                header('Location: https://schoolpea.com');
                exit;
            }
        }
        $badCredentials = true;
    } else {
        echo "Database connection failed.";
        exit;
    }
}

if ($badCredentials) {
    echo "Invalid email or password.";
}
