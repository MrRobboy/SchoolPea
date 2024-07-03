<?php
$host = 'localhost';
$dbname = 'PA';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
   
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}
