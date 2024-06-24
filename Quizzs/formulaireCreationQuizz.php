<?php
require_once('db.php');

// Traitement du formulaire de création de quizz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nom = $_POST['nom'];
    $id_cours = $_POST['id_cours'];
    $path_img_pres = $_POST['path_img_pres'];
    $path_content = $_POST['path_content'];
    $temps_limit = $_POST['temps_limit'];

    // Insertion du quizz dans la table QUIZZ
    $stmt_quizz = $dbh->prepare("INSERT INTO QUIZZ (nom, id_cours, path_img_pres, path_content, temps_limit) VALUES (?, ?, ?, ?, ?)");
    $stmt_quizz->execute([$nom, $id_cours, $path_img_pres, $path_content, $temps_limit]);

    // Récupération de l'ID du quizz inséré
    $id_quizz = $dbh->lastInsertId();

    // Si le quizz a été inséré avec succès, traiter les questions/réponses
    if ($id_quizz) {
        $questions = $_POST['questions'];

        foreach ($questions as $question_data) {
            $question_text = $question_data['question_text'];
            $choices = $question_data['choices'];
            $correct_answer = $question_data['correct_answer'];

            // Insertion de la question dans la table QUESTIONS
            $stmt_question = $dbh->prepare("INSERT INTO QUESTIONS (id_quizz, question_text) VALUES (?, ?)");
            $stmt_question->execute([$id_quizz, $question_text]);
            $id_question = $dbh->lastInsertId();

            // Insertion des choix de réponse dans la table CHOIX
            foreach ($choices as $index => $choice_text) {
                $is_correct = ($index == $correct_answer) ? 1 : 0;
                $stmt_choice = $dbh->prepare("INSERT INTO CHOIX (id_question, choix_text, est_correct) VALUES (?, ?, ?)");
                $stmt_choice->execute([$id_question, $choice_text, $is_correct]);
            }
        }

        // Redirection vers une page de confirmation ou autre après création du quizz
        header('Location: index.php');
        exit();
    }
}

// Récupération des cours pour le formulaire
$stmt_cours = $dbh->query("SELECT id_cours, nom_cours FROM COURS");
$cours = $stmt_cours->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un Quizz</title>
    <link rel="stylesheet" type="text/css" href="./quizz.css">
</head>

<body>
    <header>
        <h1>Créer un Quizz</h1>
    </header>
    <main>
        <form action="" method="post">
            <label>Nom du Quizz</label>
            <input type="text" name="nom" required>

            <label>Sélectionner un Cours</label>
            <select name="id_cours" required>
                <option value="">Choisir un cours</option>
                <?php foreach ($cours as $cours_item) : ?>
                    <option value="<?php echo $cours_item['id_cours']; ?>"><?php echo $cours_item['nom_cours']; ?></option>
                <?php endforeach; ?>
            </select>

            <label>Image de Présentation</label>
            <input type="file" name="path_img_pres" accept="image/*" required>


            <label>Temps Limite (en minutes)</label>
            <input type="number" name="temps_limit" required>

            <hr>
            <h2>Ajouter des Questions</h2>

            <div id="questions-container">
                <!-- Container pour les questions ajoutées dynamiquement -->
            </div>

            <button type="button" id="addQuestion">Ajouter une Question</button>
            <button type="submit">Créer Quizz</button>
        </form>
    </main>

    <script>
        document.getElementById('addQuestion').addEventListener('click', function() {
            var questionsContainer = document.getElementById('questions-container');
            var questionIndex = questionsContainer.childElementCount;

            var questionHTML = `
                <div class="question">
                    <h3>Question ${questionIndex + 1}</h3>
                    <label>Texte de la Question</label>
                    <textarea name="questions[${questionIndex}][question_text]" required></textarea>

                    <label>Choix de Réponses</label>
                    <div class="choices">
                        <div class="choice">
                            <label>
                                <input type="radio" name="questions[${questionIndex}][correct_answer]" value="0" required>
                                <input type="text" name="questions[${questionIndex}][choices][]" required>
                            </label>
                        </div>
                        <div class="choice">
                            <label>
                                <input type="radio" name="questions[${questionIndex}][correct_answer]" value="1">
                                <input type="text" name="questions[${questionIndex}][choices][]" required>
                            </label>
                        </div>
                        <div class="choice">
                            <label>
                                <input type="radio" name="questions[${questionIndex}][correct_answer]" value="2">
                                <input type="text" name="questions[${questionIndex}][choices][]" required>
                            </label>
                        </div>
                    </div>
                </div>
            `;

            var div = document.createElement('div');
            div.classList.add('question');
            div.innerHTML = questionHTML;

            questionsContainer.appendChild(div);
        });
    </script>
</body>

</html>