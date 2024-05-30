<?php
include_once '../Includes/database.php';

// Dans connexion.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email']; // Utilisez $email au lieu de $mail pour rester cohérent avec le nom de variable que vous avez utilisé
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if ($email != "" && $password != "") {
        // connexion à la bdd
        $req = $bdd->prepare("SELECT * FROM USER WHERE email = :email AND password = :password");
        $req->execute(array(
            "email" => $email,
            "password" => $password
        ));
        $req = $req->fetch();

        if ($req['id'] !== false) {
            //connecté
            setcookie("username", $email, time() + 3600);
            setcookie("password", $password, time() + 3600); // Vous pouvez stocker le mot de passe en cookie
            echo "Content de vous revoir " . $req['email'] . "!";
            header("Location: ../FrontEnd/Pages/compte.php");
            exit();
        } else {
            $error = "Email ou Mot de passe Incorrect ...";
        }
    }
}

?>
