<?php
$auth = $_SERVER['DOCUMENT_ROOT'];
$auth .= '/BackEnd/Includes/auth.php';
include($auth);
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

$stmt = $dbh->query("SELECT * FROM USER");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> USERS </title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Classement/classement.css">
</head>

<div class="container">
    <h1>Modifier l'Utilisateur</h1>
    <form method="post">
        <label>Email:</label>
        <input type="email" value="<?= $user['email'] ?>" disabled>
        <label>Rôle:</label>
        <select name="role">
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
        </select>
        <button type="submit">Modifier</button>
    </form>
</div>