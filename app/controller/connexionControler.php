<?php

class ConnexionController
{
    public function connexion()
    {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données du formulaire
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Valider les données du formulaire (vous pouvez implémenter la validation ici)

            // Vérifier les informations d'identification dans la base de données (vous devez implémenter cette fonctionnalité)

            // Si les informations d'identification sont valides, rediriger vers une page d'accueil connectée
            // Sinon, rediriger vers une page de connexion avec un message d'erreur
            // Exemple de redirection vers une page de connexion avec un paramètre GET pour afficher un message d'erreur :
            header("Location: " . HOST . "Accueil (non-connecté)/index.html?erreur=1");
            exit();
        } else {
            // Si le formulaire n'a pas été soumis, rediriger vers la page d'accueil
            header("Location: " . HOST . "Accueil (non-connecté)/index.html");
            exit();
        }
    }
}

?>
