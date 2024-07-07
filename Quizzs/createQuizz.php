<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crée ton Quizz</title>
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #f4f5fa;
            margin: 0;
            padding: 7em;
        }

        body.dark-mode h3,
        body.dark-mode h2 {
            color: white;
        }

        body.dark-mode form,
        body.dark-mode form .question,
        body.dark-mode form .question .choice {
            background-color: #374599;
            color: white;
        }

        body.dark-mode form label {
            color: white;
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
            max-width: 1200px;
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
        input[type="file"] {
            width: 100%;
            padding: 0.7em;
            margin-bottom: 1.5em;
            border: 1px solid #ccc;
            border-radius: 1em;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        input[type="submit"],
        button,
        body.dark-mode .add-choice {
            background-color: #6372c7;
            color: white;
            padding: 0.5em 1.5em;
            border: none;
            border-radius: 1.5em;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9em;
            margin-right: 1em;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #374599;
        }

        body.dark-mode input[type="submit"]:hover,
        body.dark-mode button:hover {
            background-color: #6372c7;
        }

        .question {
            background-color: #f9f9f9;
            margin-bottom: 1.5em;
            border: 1px solid #ccc;
            border-radius: 1em;
            padding: 1em;
            position: relative;
        }

        .choice {
            background-color: #f0f0f0;
            margin-bottom: 0.5em;
            padding: 0.5em;
            border: 1px solid #ccc;
            border-radius: 0.5em;
        }

        .effacer-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.3em 0.6em;
            border-radius: 0.5em;
            font-size: 0.8em;
            margin-top: 0.5em;
        }

        .effacer-btn:hover {
            background-color: #d32f2f;
        }

        .add-choice {
            background-color: #374599;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.3em 1em;
            border-radius: 1em;
            font-size: 0.8em;
            margin-top: 0.5em;
        }

        .add-choice:hover {
            background-color: #374599;
        }
    </style>
</head>

<body>
    <?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    if (isset($_SESSION['mail_valide'])) {
        $path .= '/headerL.php';
    } else {
        header('Location: https://schoolpea.com/Connexion');
    }
    include($path);
    ?>
    <div class="container">
        <h2>Crée un nouveau Quiz</h2>
        <form action="submitQuizz.php" method="post" enctype="multipart/form-data" id="quiz-form">
            <label for="quiz-name">Nom du Quiz:</label>
            <input type="text" name="quiz_name" id="quiz-name" required>

            <label for="quiz-description">Description:</label>
            <textarea name="quiz_description" id="quiz-description" required></textarea>

            <label for="quiz-image">Image de Présentation:</label>
            <input type="file" name="quiz_image" id="quiz-image" accept="image/*">

            <div id="questions-container"></div>

            <button type="button" id="add-question">Ajouter une Question</button>
            <input type="submit" value="Submit Quiz">
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let questionIndex = 0;

            addQuestion();

            document.getElementById('add-question').addEventListener('click', () => {
                addQuestion();
            });

            function addQuestion() {
                questionIndex++;
                const questionContainer = document.createElement('div');
                questionContainer.classList.add('question');
                questionContainer.setAttribute('data-question-index', questionIndex);

                questionContainer.innerHTML = `
                    <label>Question:</label>
                    <textarea name="questions[${questionIndex}][text]" required></textarea>
                    <button type="button" class="effacer-btn effacer-question">Effacer Question</button>
                    <div class="choices">
                        <div class="choice">
                            <input type="text" name="questions[${questionIndex}][choices][0][text]" required>
                            <label>Correct:</label>
                            <input type="checkbox" name="questions[${questionIndex}][choices][0][is_correct]">
                            <button type="button" class="effacer-btn effacer-choice">Effacer Choice</button>
                        </div>
                    </div>
                    <button type="button" class="add-choice">Ajouter un Choix</button>
                `;

                questionContainer.querySelector('.effacer-question').addEventListener('click', function() {
                    this.closest('.question').remove();
                });

                questionContainer.querySelector('.add-choice').addEventListener('click', function() {
                    addChoice(this.closest('.question'));
                });

                document.getElementById('questions-container').appendChild(questionContainer);
            }

            function addChoice(questionElement) {
                const choicesContainer = questionElement.querySelector('.choices');
                const choiceCount = choicesContainer.querySelectorAll('.choice').length;

                const choiceElement = document.createElement('div');
                choiceElement.classList.add('choice');
                choiceElement.innerHTML = `
                    <input type="text" name="questions[${questionElement.dataset.questionIndex}][choices][${choiceCount}][text]" required>
                    <label>Correct:</label>
                    <input type="checkbox" name="questions[${questionElement.dataset.questionIndex}][choices][${choiceCount}][is_correct]">
                    <button type="button" class="effacer-btn effacer-choice">Effacer Choice</button>
                `;

                choiceElement.querySelector('.effacer-choice').addEventListener('click', function() {
                    this.closest('.choice').remove();
                });

                choicesContainer.appendChild(choiceElement);
            }

            document.addEventListener('click', (event) => {
                if (event.target && event.target.classList.contains('effacer-question')) {
                    event.target.closest('.question').remove();
                }

                if (event.target && event.target.classList.contains('effacer-choice')) {
                    event.target.closest('.choice').remove();
                }
            });
        });
    </script>
</body>

</html>