<?php
global $dbh;
require_once './db.php';

// Initialize the $dbh variable properly
$dbh = new PDO($dsn, $username, $password);

$badCredentials = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the password key exists in the $_POST array
    if (!isset($_POST['password']) || !isset($_POST['email'])) {
        echo "Email or password not set.";
        exit;
    }

    $password = $_POST['password'];
    $email = $_POST['email'];

    // Prepare the SQL statement
    $getUserSql = "SELECT * FROM USER WHERE email = :email";

    if ($dbh) {
        $preparedGetUserSql = $dbh->prepare($getUserSql);
        $preparedGetUserSql->execute(['email' => $email]);

        $user = $preparedGetUserSql->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session_start();

                $_SESSION['idUser'] = $user['id_user'];
                $_SESSION['name'] = $user['name'];

                header('Location: ../FrontEnd/Pages/accueilL.php');
                exit;
            }
        }
        $badCredentials = true;
    } else {
        echo "Database connection failed.";
    }
}
?>
