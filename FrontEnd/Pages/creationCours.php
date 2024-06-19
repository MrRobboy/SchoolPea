<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un cours en ligne</title>
    <link rel="stylesheet" type="text/css" href="../Styles/style.css" />
    
</head>
<body>
    <h1>Créer un cours en ligne</h1>
    <form action="../../BackEnd/ajoutCours.php" method="post">
        <label for="nom">Nom du cours:</label><br>
        <input type="text" id="nom" name="nom" required><br>
        <label for="niveau">Niveau du cours:</label><br>
        <input type="text" id="niveau" name="niveau" required><br>
        <label for="prix">Prix du cours:</label><br>
        <input type="number" id="prix" name="prix" min="0" step="0.01" required><br>
        <label for="createur">Créateur du cours:</label><br>
        <input type="text" id="createur" name="createur" required><br><br>
        <input type="submit" value="Ajouter le cours">
        <label for="contenu">Contenu du cours:</label><br>
        <textarea id="contenu" name="contenu" rows="4" cols="50" required></textarea><br>

    </form>
</body>

</html>
