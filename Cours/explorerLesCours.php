<?php
include 'db.php';
include 'header.php';

$sql = "SELECT * FROM COURS";
$result = $conn->query($sql);

echo "<h2>Explorer les cours</h2>";
echo "<input type='text' id='search' placeholder='Rechercher des cours...' onkeyup='searchCourses()'><br><br>";

echo "<div id='course_list'>";
if ($result->rowCount() > 0) { // Utilisation de rowCount() pour vérifier le nombre de lignes
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='course_item'>";
        echo "<h3>" . $row['nom'] . "</h3>";
        echo "<img src='" . $row['path_image_pres'] . "' alt='Image de présentation' width='200'><br>";
        echo "<a href='voirCours.php?id_cours=" . $row['id_COURS'] . "'>Voir le cours</a>"; // Assurez-vous que la casse est correcte ici
        echo "</div>";
    }
} else {
    echo "Aucun cours disponible.";
}
echo "</div>";

include 'footer.php';
?>
