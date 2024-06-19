<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../Styles/barreDeRecherche.css" />
</head>
<body>
  <input
    type="text"
    class="search-bar"
    placeholder="Rechercher..."
    onkeyup="rechercherCoursEtQuizz(this.value)"
  >
  <!-- Ici, vous pouvez afficher les résultats de la recherche -->
  <div id="resultats"></div>

  <script src="../Scripts/script.js"></script>
</body>
</html>
