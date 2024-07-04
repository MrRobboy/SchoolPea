<?php

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $author = $_SESSION['user_email'];

    $sql = "INSERT INTO messages (author, content) VALUES (:author, :content)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':author', $author, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: https://schoolpea.com/Chat");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
