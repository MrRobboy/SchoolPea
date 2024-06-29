<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT email FROM USER WHERE last_active > DATE_SUB(NOW(), INTERVAL 5 MINUTE)");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
