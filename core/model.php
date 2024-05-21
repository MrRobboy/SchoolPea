<?php
class model {
    protected $db;

    public function __construct() {
        $this->initDatabase();
    }

    private function initDatabase() {
        // Initialise la connexion à la base de données
        $host = 'localhost';
        $dbname = 'PA';
        $username = 'root';
        $password = 'root';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            // Définit le mode d'erreur PDO sur Exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Gère l'erreur de connexion à la base de données
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    // Méthode pour exécuter des requêtes SQL
    protected function query($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Gère les erreurs d'exécution de la requête SQL
            die("Erreur d'exécution de la requête SQL: " . $e->getMessage());
        }
    }
}
?>
