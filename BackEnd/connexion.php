<?php
include_once '../Includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name =$_POST['name'];
    $mail = $_POST['email'];
    $password =  password_hash($_POST['password'], PASSWORD_BCRYPT);

if($email != "" && $password != ""){
    // connexion ala bdd

    $req = $bdd->query("SELECT *FROM USER WHERE email ='$email' AND password='$password'");
    $req = $req->fetch();
    if($req['id'] != false){
        //connecté
        setcookie("username", $email, time() + 3600);
        setcookie("password", time() + 3600);
        echo "Content de vous revoir ".$_COOKIE['username']. !"";
        header("Location: ../FrontEnd/Pages/compte.php");
        exit();
    }
    else {
        $error = "Email ou Mot de passe Incorrect ...";
    }
}
    
}
?>
