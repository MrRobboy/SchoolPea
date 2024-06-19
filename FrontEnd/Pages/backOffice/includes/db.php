<?php
$dsn = 'mysql:host=localhost;dbname=PA';
$username = 'root';
$password = 'root';

try {
    $bdd = new PDO("mysql:host=localhost;dbaname=PA", "root", "root");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>