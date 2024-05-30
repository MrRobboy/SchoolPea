<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Connexion | SchoolPéa</title>
    <link rel="stylesheet" type="text/css" href="../Styles/style.css" />
</head>

<body>
    <div class="container Connexion" id="Conteneur">
        <div class="form-container sign-in">
            <form action="" method="post">
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

                <h1>Connexion</h1>
                <input type="email" id="email" name="email" placeholder="email" required />
                <input type="password" id="password" name="password" placeholder="Mot de passe" required />
                <a href="#">Mot de passe oublié ?</a>
                <button type="submit" name="submit">Connexion</button>
            </form>
        </div>

        <div class="form-container sign-up">
            <form action="" method="post">
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
                <h1 style="text-align: center">Bienvenue chez SchoolPéa</h1>
                <input type="text" id="name" name="name" placeholder="Name" />
                <input type="email" id="email" name="email" placeholder="email" />
                <input type="password" id="password" name="password" placeholder="Mot de passe" />
                <p><?php if (isset($_GET['password']) && $_GET['password'] === '0') {
                        echo ('Mauvais mdp');
                    } ?></p>
                <button type="submit">Inscription</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Te revoila !</h1>
                    <button class="hidden" id="Connexion">Connexion</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>T'es nouveau ?</h1>
                    <button class="hidden" id="Inscription">Inscription</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../Scripts/script.js"></script>
</body>

</html>