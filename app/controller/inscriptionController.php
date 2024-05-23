<?php

class InscriptionController
{
    private $utilisateur;

    public function __construct($db)
    {
        // Instanciez votre modèle Utilisateur avec la connexion à la base de données
        $this->utilisateur = new Utilisateur($db);
    }

    public function inscription()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Appelez la méthode du modèle pour inscrire un nouvel utilisateur
            $inscriptionReussie = $this->utilisateur->inscrire($name, $email, $password);

            if ($inscriptionReussie) {
                // Redirigez l'utilisateur vers une page de confirmation, par exemple :
                header("Location: inscription_reussie.php");
                exit();
            } else {
                // Gérez l'erreur d'inscription, par exemple affichez un message d'erreur
                echo "Erreur lors de l'inscription.";
            }
        }

        // Affichez la vue d'inscription
        include("inscription.php");
    }
}

?>
