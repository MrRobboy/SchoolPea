<?php
session_start();
include('db.php');
$dbh->exec('USE PA');
$message = $_SESSION['id_USER'] . ' - ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' s\'est déconnecté !';
$queryLogs = $dbh->prepare('INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg);');
$queryLogs->bindvalue(':id_USER', $user_found[0]['id_USER']);
$queryLogs->bindvalue(':msg', $message);
$result2 = $queryLogs->execute();

session_unset();
session_destroy();

header('Location: https://schoolpea.com');
