<?php
include_once '../Includes/database.php';

$error = false;
$passwordError = false;

if ( isset($_POST['name']) && strlen($_POST['name']) < 2) {
    $error = true;
}

if ( isset($_POST['email']) && !preg_match("/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['email']) ) {
    $error = true;
}
if ( isset($_POST['password']) && !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['password']) ) {
    $passwordError = true;
}

if ($passwordError || $error) {
    $location = 'Location: ../FrontEnd/Pages/inscription.php?';

    if ($passwordError) {
        $location = $location . 'password=0';
    }

    header($location);
}

if(isset($_POST['submit'])){
    $name =$_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    
    $sql = "
INSERT INTO USER (name, email,  password)
VALUES ( :name, :email, :passwordHash );
";

$queryStatement = $dbh->prepare($sql);

$queryStatement->execute([
  "name" => $name,
  "email" => $email,
  "password" =>$passwordhasher
]);
}