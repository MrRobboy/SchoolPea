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
    echo "<div class='cours-description'>" . htmlspecialchars($cours['description']) . "</div>";  // Afficher la description du cours

    // Bouton pour générer le PDF du cours
    echo '<a href="downloadPdf.php?id_cours=' . $id_cours . '" class="button">Télécharger le PDF</a>';

    // Bouton pour suivre le cours
    echo '<button onclick="followCourse(' . $id_cours . ')" class="button">Suivre ce cours</button>';

    // Récupérer les sections liées au cours
    $sql_section = "SELECT * FROM SECTIONS WHERE id_cours = ?";
    $stmt_section = $dbh->prepare($sql_section);
    $stmt_section->execute([$id_cours]);

    if ($stmt_section->rowCount() > 0) {
        while ($section = $stmt_section->fetch(PDO::FETCH_ASSOC)) {
            echo "<h3>" . htmlspecialchars($section['titre']) . "</h3>";

            // Récupérer les titres liés à la section
            $id_section = $section['id_section'];
            $sql_titre = "SELECT * FROM TITRE WHERE id_section = ?";
            $stmt_titre = $dbh->prepare($sql_titre);
            $stmt_titre->execute([$id_section]);

            if ($stmt_titre->rowCount() > 0) {
                while ($titre = $stmt_titre->fetch(PDO::FETCH_ASSOC)) {
                    echo "<h4>" . htmlspecialchars($titre['titre']) . "</h4>";

                    // Récupérer les paragraphes liés au titre
                    $id_titre = $titre['id_titre'];
                    $sql_paragraphe = "SELECT * FROM PARAGRAPHE WHERE id_titre = ?";
                    $stmt_paragraphe = $dbh->prepare($sql_paragraphe);
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function followCourse(id_cours) {
    $.ajax({
        type: "POST",
        url: "followCourse.php",
        data: { id_cours: id_cours },
        success: function(response) {
            alert(response); // Affiche le message de succès ou d'erreur
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors de la requête AJAX : " + status, error);
        }
    });
}
</script>
