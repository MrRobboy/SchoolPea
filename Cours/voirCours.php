<?php
include 'db.php';
include 'header.php';

$id_cours = $_GET['id_cours'];
$sql = "SELECT * FROM COURS WHERE id_COURS = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_cours]);

if ($stmt->rowCount() > 0) {
    $cours = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<h2>" . htmlspecialchars($cours['nom']) . "</h2>";
    echo "<p>Niveau : " . htmlspecialchars($cours['niveau']) . "</p>";
    echo "<p>Prix : " . htmlspecialchars($cours['prix']) . "€</p>";
    echo "<img src='" . htmlspecialchars($cours['path_image_pres']) . "' alt='Image de présentation' width='300'><br>";
    
    $sql_section = "SELECT * FROM SECTIONS WHERE id_cours = ?";
    $stmt_section = $conn->prepare($sql_section);
    $stmt_section->execute([$id_cours]);
    
    if ($stmt_section->rowCount() > 0) {
        while ($section = $stmt_section->fetch(PDO::FETCH_ASSOC)) {
            echo "<h3>" . htmlspecialchars($section['titre']) . "</h3>";
            
            $id_section = $section['id_section'];
            $sql_titre = "SELECT * FROM TITRE WHERE id_section = ?";
            $stmt_titre = $conn->prepare($sql_titre);
            $stmt_titre->execute([$id_section]);
            
            if ($stmt_titre->rowCount() > 0) {
                while ($titre = $stmt_titre->fetch(PDO::FETCH_ASSOC)) {
                    echo "<h4>" . htmlspecialchars($titre['titre']) . "</h4>";
                    
                    $id_titre = $titre['id_titre'];
                    $sql_paragraphe = "SELECT * FROM PARAGRAPHE WHERE id_titre = ?";
                    $stmt_paragraphe = $conn->prepare($sql_paragraphe);
                    $stmt_paragraphe->execute([$id_titre]);
                    
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
