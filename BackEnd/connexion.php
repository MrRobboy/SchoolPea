<?php
global $dbh;
require_once './db.php';

$badCredentials = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    $getUserSql = "SELECT * FROM USER WHERE email = :email";

    $preparedGetUserSql = $dbh->prepare($getUserSql);
    $preparedGetUserSql->execute([
        'email' => $_POST['email']
    ]);

    $user = $preparedGetUserSql->fetch();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            session_start();

            $_SESSION['idUser'] = $user['id_user'];
            $_SESSION['name'] = $user['name'];


            header('Location: ../FrontEnd/Pages/compte.php');
        }
    }
    $badCredentials = true;
}
