<?php
include 'db.php'; 
include 'header.php';

$id_cours = $_GET['id_cours'];

// Exemple en supposant que $dbh est l'objet de connexion PDO
$sql = "SELECT * FROM COURS WHERE id_COURS = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$id_cours]);

if ($stmt->rowCount() > 0) {
    $cours = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<h2>" . htmlspecialchars($cours['nom']) . "</h2>";
    echo "<p>Niveau : " . htmlspecialchars($cours['niveau']) . "</p>";
   

    // Récupérer les sections liées au cours
    $sql_section = "SELECT * FROM SECTIONS WHERE id_cours = ?";
    $stmt_section = $dbh->prepare($sql_section);
    $stmt_section->execute([$id_cours]);

    if ($stmt_section->rowCount() > 0) {
        while ($section = $stmt_section->fetch(PDO::FETCH_ASSOC)) {
            echo "<h3>" . htmlspecialchars($section['titre']) . "</h3>";

            // Récupérer les titres liés à la section
            $id_cours = $section['id_cours'];
            $sql_titre = "SELECT * FROM TITRE WHERE id_cours = ?";
            $stmt_titre = $dbh->prepare($sql_titre);
            $stmt_titre->execute([$id_cours]);

            if ($stmt_titre->rowCount() > 0) {
                while ($titre = $stmt_titre->fetch(PDO::FETCH_ASSOC)) {
                    echo "<h4>" . htmlspecialchars($titre['titre']) . "</h4>";

                    // Récupérer les paragraphes liés au titre
                    $id_cours = $titre['id_cours'];
                    $sql_paragraphe = "SELECT * FROM PARAGRAPHE WHERE id_cours = ?";
                    $stmt_paragraphe = $dbh->prepare($sql_paragraphe);
                    $stmt_paragraphe->execute([$id_cours]);

                    if ($stmt_paragraphe->rowCount() > 0) {
                        while ($paragraphe = $stmt_paragraphe->fetch(PDO::FETCH_ASSOC)) {
                            echo "<p>" . htmlspecialchars($paragraphe['contenu']) . "</p>";
                        }
                    }
                }
            }
        }
    }
} else {
    echo "Cours non trouvé.";
}

include 'footer.php';
?>
