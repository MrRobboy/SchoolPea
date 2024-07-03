<?php

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $author = $_SESSION['user_email']; // assuming email is stored in session

    $sql = "INSERT INTO messages (author, content) VALUES (:author, :content)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':author', $author, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: chat.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
