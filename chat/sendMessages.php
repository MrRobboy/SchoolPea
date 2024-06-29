<?php
session_start();
if(!isset($_SESSION['id_USER'])){
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $message = $_POST['message'];
    $id_USER = $_SESSION['id_USER'];

    $stmt = $conn->prepare("INSERT INTO messages (id_USER, message) VALUES (:id_USER, :message)");
    $stmt->bindParam(':id_USER', $id_USER);
    $stmt->bindParam(':message', $message);

    $stmt->execute();
    echo "Message sent successfully";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
