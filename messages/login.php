<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $stmt = $conn->prepare("SELECT id_USER FROM USER WHERE email = :email AND pass = :pass");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $pass);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['user_id'] = $stmt->fetch(PDO::FETCH_ASSOC)['id_USER']; // Correction ici
        header("Location: message_board.php");
        exit();
    } else {
        echo "Invalid email or pass";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<form method="POST" action="">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>
    <label for="pass">Password:</label>
    <input type="password" id="pass" name="pass" required> <!-- Correction ici -->
    <button type="submit">Login</button>
</form>
</body>
</html>
