<?php
include_once '../Includes/database.php';

if(isset($_POST['submit'])){
    $name =$_POST['name'];
    $email = $_POST['email'];
    $password =  password_hash($_POST['password'], PASSWORD_BCRYPT);

    $requete = $bdd->prepare("INSERT INTO USER VALUES (0, :name, :email, :password)");
    $requete->execute(
        array(
            "name" => $name,
            "email" => $email,
            "password" =>$password

        )
        );
        header("Location: ../FrontEnd/Pages/confirmationInscription");
exit();

}
?>