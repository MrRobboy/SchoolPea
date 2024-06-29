<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $profile_picture = $_FILES['profile_picture']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_picture);
    
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO USER (firstname, lastname, email, pass, path_pp) 
                VALUES ('$firstname', '$lastname', '$email', '$password', '$target_file')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Inscription réussie. <a href='index.html'>Connectez-vous ici</a>";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
    }
}

$conn->close();
?>
