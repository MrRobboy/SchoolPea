<?php
require_once 'tcpdf/tcpdf.php';
include 'db.php';

$id_cours = $_GET['id_cours'];
$sql = "SELECT * FROM COURS WHERE id_cours = ?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$id_cours]);

if ($stmt->rowCount() > 0) {
    $cours = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->Cell(0, 10, $cours['nom'], 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(10);
    $pdf->MultiCell(0, 10, $cours['description'], 0, 1);
    $pdf->Ln(5);

    // Ajouter les sections, titres et paragraphes comme dans votre exemple précédent

    $sql_section = "SELECT * FROM SECTIONS WHERE id_cours = ?";
    $stmt_section = $dbh->prepare($sql_section);
    $stmt_section->execute([$id_cours]);

    if ($stmt_section->rowCount() > 0) {
        while ($section = $stmt_section->fetch(PDO::FETCH_ASSOC)) {
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, $section['titre'], 0, 1);
            $pdf->SetFont('helvetica', '', 12);
            
            $id_section = $section['id_section'];
            $sql_titre = "SELECT * FROM TITRE WHERE id_section = ?";
            $stmt_titre = $dbh->prepare($sql_titre);
            $stmt_titre->execute([$id_section]);

            if ($stmt_titre->rowCount() > 0) {
                while ($titre = $stmt_titre->fetch(PDO::FETCH_ASSOC)) {
                    $pdf->SetFont('helvetica', 'I', 14);
                    $pdf->Cell(0, 10, $titre['titre'], 0, 1);
                    $pdf->SetFont('helvetica', '', 12);
                    
                    $id_titre = $titre['id_titre'];
                    $sql_paragraphe = "SELECT * FROM PARAGRAPHE WHERE id_titre = ?";
                    $stmt_paragraphe = $dbh->prepare($sql_paragraphe);
                    $stmt_paragraphe->execute([$id_titre]);

                    if ($stmt_paragraphe->rowCount() > 0) {
                        while ($paragraphe = $stmt_paragraphe->fetch(PDO::FETCH_ASSOC)) {
                            $pdf->MultiCell(0, 10, $paragraphe['contenu'], 0, 1);
                            $pdf->Ln(5);
                        }
                    }
                }
            }
        }
    }

    $pdf->Output('cours_' . $id_cours . '.pdf', 'D');
} else {
    echo "Cours non trouvé.";
}
?>
