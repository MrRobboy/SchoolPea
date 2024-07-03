<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=PA';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>
