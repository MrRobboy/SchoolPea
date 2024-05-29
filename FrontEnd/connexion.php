<?php
require '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id_user, mdp FROM USER WHERE mail = :email";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mdp'])) {
        session_start();
        $_SESSION['id_user'] = $user['id_user'];
        header("Location: ./accueil_nl.php?login=success");
    } else {
        header("Location: ./index.php?password=0");
    }
}
?>
