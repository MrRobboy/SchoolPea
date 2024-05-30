<?php
include_once '../Includes/database.php';

if(isset($_POST['submit'])){
    $name =$_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $passwordhasher = password_hash($password, PASSWORD_BCRYPT);

    
    $requete = $bdd->prepare("INSERT INTO USER (name, email, password) VALUES (:name, :email, :password)");
    $requete->execute(
        array(
            "name" => $name,
            "email" => $email,
            "password" =>$passwordhasher

        )
        );
          // Redirection après l'insertion réussie
        header("Location: ../FrontEnd/Pages/confirmationInscription");

}
?>