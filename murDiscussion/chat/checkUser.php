<?php

require_once('db.php');
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT email, path_pp FROM USER WHERE id_USER = :user_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
