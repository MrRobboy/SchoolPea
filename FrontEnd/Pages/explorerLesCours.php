<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cours</title>
    <style>
        <?php include 'styles.css'; ?>
    </style>
</head>
<body>
    <div id="Cours_section">
        <span>
            <p id="titre_cours">Une large sélection de Cours</p>
        </span>
        <div class="fenetre">
        <?php
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $bdd = new PDO("mysql:host=localhost;dbname=PA", "root", "root", $options);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Récupération des cours depuis la base de données
            $sql = "SELECT * FROM COURS";
            $stmt = $bdd->query($sql);

            $counter = 0;
            while ($row = $stmt->fetch()) {
                if ($counter % 4 == 0 && $counter != 0) {
                    echo "</div><div class='fenetre'>";
                }
                echo "<span id='fen" . ($counter + 1) . "'>" . $row["nom"] . "</span>";
                $counter++;
            }
            
            if ($counter == 0) {
                echo "<span>Aucun cours trouvé.</span>";
            }

        } catch (PDOException $e) {
            echo "Erreur Connexion : " . $e->getMessage();
            die;
        }
        ?>
        </div>
    </div>
</body>
</html>
