<?php
require_once 'tcpdf/tcpdf.php';
include 'db.php';

$id_cours = $_GET['id_cours'];
$sql = "SELECT * FROM COURS WHERE id_cours = $id_cours";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cours = $result->fetch_assoc();
    
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->Cell(0, 10, $cours['nom'], 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(10);
    
    $sql_section = "SELECT * FROM SECTION WHERE id_cours = $id_cours";
    $result_section = $conn->query($sql_section);
    
    if ($result_section->num_rows > 0) {
        while ($section = $result_section->fetch_assoc()) {
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, $section['titre'], 0, 1);
            $pdf->SetFont('helvetica', '', 12);
            
            $id_section = $section['id_section'];
            $sql_titre = "SELECT * FROM TITRE WHERE id_section = $id_section";
            $result_titre = $conn->query($sql_titre);
            
            if ($result_titre->num_rows > 0) {
                while ($titre = $result_titre->fetch_assoc()) {
                    $pdf->SetFont('helvetica', 'I', 14);
                    $pdf->Cell(0, 10, $titre['titre'], 0, 1);
                    $pdf->SetFont('helvetica', '', 12);
                    
                    $id_titre = $titre['id_titre'];
                    $sql_paragraphe = "SELECT * FROM PARAGRAPHE WHERE id_titre = $id_titre";
                    $result_paragraphe = $conn->query($sql_paragraphe);
                    
                    if ($result_paragraphe->num_rows > 0) {
                        while ($paragraphe = $result_paragraphe->fetch_assoc()) {
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
