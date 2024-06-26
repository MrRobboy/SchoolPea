<?php
include 'db.php';
include 'header.php';

$id_cours = $_GET['id_cours'];
$sql = "SELECT * FROM COURS WHERE id_cours = $id_cours";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cours = $result->fetch_assoc();
    echo "<h2>" . $cours['nom'] . "</h2>";
    echo "<p>Niveau : " . $cours['niveau'] . "</p>";
    echo "<p>Prix : " . $cours['prix'] . "€</p>";
    echo "<img src='" . $cours['path_image_pres'] . "' alt='Image de présentation' width='300'><br>";
    
    $sql_section = "SELECT * FROM SECTION WHERE id_cours = $id_cours";
    $result_section = $conn->query($sql_section);
    
    if ($result_section->num_rows > 0) {
        while ($section = $result_section->fetch_assoc()) {
            echo "<h3>" . $section['titre'] . "</h3>";
            
            $id_section = $section['id_section'];
            $sql_titre = "SELECT * FROM TITRE WHERE id_section = $id_section";
            $result_titre = $conn->query($sql_titre);
            
            if ($result_titre->num_rows > 0) {
                while ($titre = $result_titre->fetch_assoc()) {
                    echo "<h4>" . $titre['titre'] . "</h4>";
                    
                    $id_titre = $titre['id_titre'];
                    $sql_paragraphe = "SELECT * FROM PARAGRAPHE WHERE id_titre = $id_titre";
                    $result_paragraphe = $conn->query($sql_paragraphe);
                    
                    if ($result_paragraphe->num_rows > 0) {
                        while ($paragraphe = $result_paragraphe->fetch_assoc()) {
                            echo "<p>" . $paragraphe['contenu'] . "</p>";
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
