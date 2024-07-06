<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participer au Quiz</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers votre fichier de style CSS -->
</head>
<body>
    <div class="container">
        <h2>Quiz: <?php echo htmlspecialchars($quiz['nom']); ?></h2>
        <form action="participerQuizz.php?id_quizz=<?php echo $idQuizz; ?>&question=<?php echo $currentQuestion; ?>" method="post" id="quiz-form" onsubmit="return validateQuestion()">
            <h3>Question <?php echo $currentQuestion; ?>:</h3>
            <p><?php echo htmlspecialchars($currentQuestionData['question_text']); ?></p>

            <div id="choices-container">
                <?php if (!empty($choices)) : ?>
                    <?php foreach ($choices as $choice) : ?>
                        <div>
                            <input type="checkbox" name="answers[<?php echo $currentQuestionData['id_question']; ?>][]" value="<?php echo $choice['id_CHOIX']; ?>" id="choice-<?php echo $choice['id_CHOIX']; ?>">
                            <label for="choice-<?php echo $choice['id_CHOIX']; ?>"><?php echo htmlspecialchars($choice['choix_text']); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucun choix trouvé pour cette question.</p>
                <?php endif; ?>
            </div>

            <button type="submit">Suivant</button>
        </form>
    </div>

    <script>
        function validateQuestion() {
            var form = document.getElementById('quiz-form');
            var checkboxes = form.elements['answers[<?php echo $currentQuestionData['id_question']; ?>][]'];
            var answered = false;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    answered = true;
                    break;
                }
            }

            if (!answered) {
                alert('Veuillez sélectionner au moins une réponse.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
