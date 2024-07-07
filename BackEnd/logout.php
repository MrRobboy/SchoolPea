<?php
session_start();

include('db.php');

$dbh->exec('USE PA');

$queryLogs = $dbh->prepare('SELECT * FROM USER WHERE id_USER=:id_USER');
$queryLogs->bindvalue(':id_USER', $_SESSION['id_user']);
$result1 = $queryLogs->execute();

if ($result1[0]['id_USER'] == $_SESSION['id_USER']) {
    $message = $_SESSION['id_user'] . ' - ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' s\'est déconnecté !';

    $queryLogs = $dbh->prepare('INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg);');
    $queryLogs->bindvalue(':id_USER', $_SESSION['id_user']);
    $queryLogs->bindvalue(':msg', $message);

    $result2 = $queryLogs->execute();
}

session_unset();
session_destroy();

header('Location: https://schoolpea.com');
