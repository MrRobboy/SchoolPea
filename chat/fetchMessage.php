<?php
session_start();
include 'db.php';

$sql = "SELECT MESSAGE.message, MESSAGE.send_at, USER.email, USER.path_pp  
        FROM MESSAGE 
        JOIN USER ON MESSAGE.send_by = USER.id 
        ORDER BY MESSAGE.send_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$MESSAGE = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($MESSAGE);
?>
