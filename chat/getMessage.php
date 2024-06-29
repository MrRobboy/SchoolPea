<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10; // Nombre de messages par page
    $offset = ($page - 1) * $limit;

    $stmt = $conn->prepare("SELECT USER.email, USER.path_pp, messages.message, messages.timestamp FROM messages JOIN USER ON messages.id_USER = USER.id_USER ORDER BY messages.timestamp DESC LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
