<?php

class user
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function inscrire($name, $email, $password)
    {
        // Exécutez votre requête SQL pour insérer un nouvel utilisateur dans la base de données
        // Utilisez des requêtes préparées pour empêcher les injections SQL
        // Par exemple :
        // $stmt = $this->db->prepare("INSERT INTO utilisateurs (name, email, password) VALUES (?, ?, ?)");
        // $stmt->execute([$name, $email, $password]);
        // Vérifiez si l'insertion a réussi et renvoyez true ou false en conséquence
    }

    public function verifierConnexion($email, $password)
    {
        // Exécutez votre requête SQL pour vérifier les informations d'identification dans la base de données
        // Par exemple :
        // $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = ? AND password = ?");
        // $stmt->execute([$email, $password]);
        // $user = $stmt->fetch();
        // Si l'utilisateur est trouvé, renvoyez true, sinon renvoyez false
    }
}

?>
