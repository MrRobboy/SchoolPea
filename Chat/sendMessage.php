<?php
session_start();
require('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = stripslashes(trim(htmlspecialchars($_POST['content'])));
    $author = $_SESSION['email'];

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
