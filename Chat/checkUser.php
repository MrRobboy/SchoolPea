<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

function isUserLoggedIn()
{
    return empty($_SESSION['id_USER']);
}

if (!isUserLoggedIn()) {
    header("Location: https://schoolpea.com/Connexion");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT email, path_pp FROM USER WHERE id_USER = :user_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
