<?php
session_start();
$bdd = new PDO('mysql: host=localhost; dbname=PA; charset=utf-8;', 'root' , 'root');
if (isset($_POST['submit']))
{
    if(!empty($_POST['name']) and !empty($_POST['email']) and !empty($_POST['password']));
    {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = sha1($_POST['password']);
        $insertUser = $bdd->prepare('INSERT INTO USER(nom_user,mail,mdp)VALUES(?,?,?)');
        $insertUser->execute(array($name,$email,$password));

        $recupUser =$bdd->prepare('SELECT * FROM USER WHERE mail = ? and mdp = ?');
        $recupUser->execute(array($email,$password));

    
        if ($recupUser->rowCount() > 0){
                $_SESSION['mail'] = $email;
                $_SESSION['mdp'] =  $password;
                $_SESSION['id'] = $recupUser->fetch()['id'];
            
        }
        
        
        else {
            echo "Veuillez completer tous les champs...";
            }
    }
}
