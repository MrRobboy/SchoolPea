<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Quiz</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier style.css commun -->
    <style>
        /* Styles spécifiques à la page de création de quiz */
        body {
            font-family: "Montserrat", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #f4f5fa;
            margin: 0;
            padding: 2em;
        }
        h2 {
            color: #374599;
            font-weight: 700;
            margin-bottom: 1em;
        }
        form {
            background-color: #ffffff;
            border-radius: 2em;
            box-shadow: 0 0 90px rgba(200, 200, 255, 0.75);
            padding: 2em 4em;
            max-width: 800px;
            width: 100%;
        }
        label {
            display: block;
            margin-bottom: 0.5em;
            color: #374599;
            font-weight: 500;
        }
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 0.7em;
            margin-bottom: 1.5em;
            border: 1px solid #ccc;
            border-radius: 1em;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }
        input[type="submit"] {
            background-color: #8493e8;
            color: white;
            padding: 0.7em 2.5em;
            border: none;
            border-radius: 1.5em;
            cursor: pointer;
            font-weight: 600;
            font-size: 1em;
        }
        input[type="submit"]:hover {
            background-color: #374599;
        }
        h3 {
            color: #374599;
            font-weight: 600;
            margin-bottom: 1em;
        }
        .question {
            background-color: #f9f9f9;
            margin-bottom: 1.5em;
            border: 1px solid #ccc;
            border-radius: 1em;
            padding: 1em;
            position: relative;
        }
        .question input[type="text"],
        .question textarea {
            width: calc(100% - 2.5em);
            padding: 0.5em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 0.5em;
        }
        .answer {
            background-color: #f0f0f0;
            margin-bottom: 0.5em;
            padding: 0.5em;
            border: 1px solid #ccc;
            border-radius: 0.5em;
        }
        .answer input[type="text"] {
            width: calc(100% - 2.5em);
            padding: 0.3em;
            margin-bottom: 0.5em;
            border: 1px solid #ccc;
            border-radius: 0.5em;
        }
        .remove-btn {
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.3em 0.6em;
            border-radius: 0.5em;
            font-size: 0.9em;
            margin-top: 0.5em;
        }
        .add-answer-btn {
            background-color: #6b7ad2;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.3em 1em;
            border-radius: 1em;
            font-size: 0.9em;
            margin-top: 0.5em;
        }
        .add-answer-btn:hover {
            background-color: #8493e8;
        }
    </style>
</head>
<body>
    <h2>Création de Quiz</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <label for="quiz_name">Nom du Quiz :</label>
        <input type="text" id="quiz_name" name="quiz_name" required><br><br>
        <label for="quiz_description">Description :</label>
        <textarea id="quiz_description" name="quiz_description" rows="4" required></textarea><br><br>
        <label for="quiz_image">Image du Quiz :</label>
        <input type="file" id="quiz_image" name="quiz_image" accept="image/jpeg, image/png, image/gif"><br><br>
        <h3>Questions :</h3>
        <div id="questions"></div>
        <button type="button" id="ajouter_question">Ajouter une Question</button><br><br>
        <input type="submit" value="Créer le Quiz">
    </form>
    <script>
        document.getElementById('ajouter_question').addEventListener('click', function() {
            var questionsDiv = document.getElementById('questions');
            var nextQuestionIndex = questionsDiv.children.length;
            var newQuestion = document.createElement('div');
            newQuestion.className = 'question';
            var questionLabel = document.createElement('label');
            questionLabel.textContent = 'Question ' + (nextQuestionIndex + 1) + ' :';
            newQuestion.appendChild(questionLabel);
            var questionInput = document.createElement('textarea');
            questionInput.name = 'questions[' + nextQuestionIndex + '][text]';
            questionInput.placeholder = 'Posez votre question ici';
            questionInput.required = true;
            newQuestion.appendChild(questionInput);
            var answersDiv = document.createElement('div');
            answersDiv.className = 'answers';
            var addAnswerButton = document.createElement('button');
            addAnswerButton.type = 'button';
            addAnswerButton.className = 'add-answer-btn';
            addAnswerButton.textContent = 'Ajouter une Réponse';
            addAnswerButton.onclick = function() {
                addAnswer(answersDiv, nextQuestionIndex);
            };
            newQuestion.appendChild(addAnswerButton);
            newQuestion.appendChild(answersDiv);
            var removeQuestionButton = document.createElement('button');
            removeQuestionButton.className = 'remove-btn';
            removeQuestionButton.type = 'button';
            removeQuestionButton.textContent = 'Supprimer';
            removeQuestionButton.onclick = function() {
                questionsDiv.removeChild(newQuestion);
            };
            newQuestion.appendChild(removeQuestionButton);
            questionsDiv.appendChild(newQuestion);
        });
        function addAnswer(answersDiv, questionIndex) {
            var nextAnswerIndex = answersDiv.children.length;
            var newAnswer = document.createElement('div');
            newAnswer.className = 'answer';
            var answerInput = document.createElement('input');
            answerInput.type = 'text';
            answerInput.name = 'questions[' + questionIndex + '][answers][' + nextAnswerIndex + '][text]';
            answerInput.placeholder = 'Réponse';
            answerInput.required = true;
            newAnswer.appendChild(answerInput);
            var correctCheckbox = document.createElement('input');
            correctCheckbox.type = 'checkbox';
            correctCheckbox.name = 'questions[' + questionIndex + '][answers][' + nextAnswerIndex + '][is_correct]';
            correctCheckbox.id = 'correct_' + questionIndex + '_' + nextAnswerIndex;
            newAnswer.appendChild(correctCheckbox);
            var correctLabel = document.createElement('label');
            correctLabel.textContent = 'Correct';
            correctLabel.setAttribute('for', 'correct_' + questionIndex + '_' + nextAnswerIndex);
            newAnswer.appendChild(correctLabel);
            var removeAnswerButton = document.createElement('button');
            removeAnswerButton.className = 'remove-btn';
            removeAnswerButton.type = 'button';
            removeAnswerButton.textContent = 'Supprimer';
            removeAnswerButton.onclick = function() {
                answersDiv.removeChild(newAnswer);
            };
            newAnswer.appendChild(removeAnswerButton);
            answersDiv.appendChild(newAnswer);
        }
    </script>
</body>
</html>
