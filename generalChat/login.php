<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM USER WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['pass'])) {
            $_SESSION['user_id'] = $row['id_USER'];
            header("Location: chat.php");
        } else {
            echo "Mot de passe invalide.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }
}

$conn->close();
?>
