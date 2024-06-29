<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $keyword = $_GET['keyword'];

    $stmt = $conn->prepare("SELECT USER.email, USER.path_pp, messages.message, messages.timestamp FROM messages JOIN USER ON messages.id_USER = USER.id_USER WHERE messages.message LIKE :keyword ORDER BY messages.timestamp DESC");
    $stmt->bindValue(':keyword', '%' . $keyword . '%');
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
