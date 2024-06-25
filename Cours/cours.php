<?php
session_start();
require_once 'db.php';

$id_cours = $_GET['id'];
$query = $db->prepare("SELECT * FROM COURS WHERE id = ?");
$query->execute([$id_cours]);
$course = $query->fetch(PDO::FETCH_ASSOC);

$sections_query = $db->prepare("SELECT * FROM sections WHERE id_cours = ?");
$sections_query->execute([$id_cours]);
$sections = $sections_query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['like'])) {
    $stmt = $db->prepare("INSERT INTO LIKES (id_user, id_cours) VALUES (?, ?)");
    $stmt->execute([$_SESSION['id_user'], $id_cours]);
    header("Location: mesCours.php");
}

if (isset($_POST['download'])) {
    require_once 'tcpdf/tcpdf.php';

    $pdf = new TCPDF();
    $pdf->AddPage();

    $html = '<h1>' . $course['name'] . '</h1>';
    $html .= '<img src="uploads/' . $course['image'] . '" alt="' . $course['name'] . '">';
    $html .= '<p>Niveau : ' . $course['level'] . '</p>';
    $html .= '<p>Prix : ' . ($course['price'] == 0 ? 'Gratuit' : $course['price'] . ' €') . '</p>';
    $html .= '<h2>Sommaire</h2>';
    $html .= '<ul>';
    foreach ($sections as $section) {
        $html .= '<li>' . $section['title'] . '</li>';
    }
    $html .= '</ul>';

    foreach ($sections as $section) {
        $html .= '<h3>' . $section['title'] . '</h3>';
        $html .= '<p>' . $section['content'] . '</p>';
    }

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('cours.pdf', 'D');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($course['name']) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1><?= htmlspecialchars($course['name']) ?></h1>
    <img src="uploads/<?= htmlspecialchars($course['image']) ?>" alt="<?= htmlspecialchars($course['name']) ?>">
    <p>Niveau : <?= htmlspecialchars($course['level']) ?></p>
    <p>Prix : <?= $course['price'] == 0 ? 'Gratuit' : htmlspecialchars($course['price']) . ' €' ?></p>

    <h2>Sommaire</h2>
    <ul>
        <?php foreach ($sections as $section): ?>
            <li><a href="#section-<?= htmlspecialchars($section['id']) ?>"><?= htmlspecialchars($section['title']) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <?php foreach ($sections as $section): ?>
        <h3 id="section-<?= htmlspecialchars($section['id']) ?>"><?= htmlspecialchars($section['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($section['content'])) ?></p>
    <?php endforeach; ?>

    <form action="cours.php?id=<?= $id_cours ?>" method="post">
        <button type="submit" name="like">Liker</button>
        <button type="submit" name="download">Télécharger en PDF</button>
    </form>
</body>
</html>
