<?php
session_start();
require_once './db.php';

$badCredentials = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the password and email keys exist in the $_POST array
    if (!isset($_POST['password_connexion']) || !isset($_POST['email_connexion'])) {
        echo "Email or password not set.";
        exit;
    }
    echo ('mail valide');

    $password = $_POST['password_connexion'];
    $email = $_POST['email_connexion'];

    // Prepare the SQL statement
    $getUserSql = 'USE PA; SELECT * FROM USER WHERE email =' . $email . ';';

    $preparedGetUserSql = $dbh->query($getUserSql);
    $user = $preparedGetUserSql->fetchAll();
    echo ('<pre>' . print_r($user) . '</pre>');
    if (!empty($user) && $user[0]['validation_mail'] == true) {
        if (password_verify($password, $user[0]['password'])) {
            $_SESSION['id_user'] = htmlspecialchars($user[0]['id_user']);
            $_SESSION['email'] = htmlspecialchars($user[0]['email']);
            $_SESSION['firstname'] = htmlspecialchars($user[0]['firstname']);
            $_SESSION['lastname'] = htmlspecialchars($user[0]['lastname']);
            $_SESSION['path_pp'] = htmlspecialchars($user[0]['path_pp']);
            $_SESSION['elo'] = htmlspecialchars($user[0]['elo']);
            $_SESSION['role'] = htmlspecialchars($user[0]['role']);
            $_SESSION['validation_mail'] = htmlspecialchars($user[0]['validation_mail']);
            // header('Location: https://schoolpea.com');
            exit;
        }
        $badCredentials = true;
    } else echo ('Mail non validé !!!!');
}

if ($badCredentials) {
    echo "Invalid email or password.";
}
