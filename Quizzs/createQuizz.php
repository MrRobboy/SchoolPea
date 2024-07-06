<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    
</head>
<style>       /* Styles spécifiques à la page de création de quiz */
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
<body>
    <div class="container">
        <h2>Create a New Quiz</h2>
        <form action="submitQuizz.php" method="post" enctype="multipart/form-data" id="quiz-form">
            <label for="quiz-name">Quiz Name:</label>
            <input type="text" name="quiz_name" id="quiz-name" required>

            <label for="quiz-description">Description:</label>
            <textarea name="quiz_description" id="quiz-description" required></textarea>

            <label for="quiz-image">Image de Présentation:</label>
            <input type="file" name="quiz_image" id="quiz-image" accept="image/*">

            <div id="questions-container">
                <!-- Placeholder for dynamic questions and choices -->
            </div>
            
            <button type="button" id="add-question">Add Question</button>
            <button type="submit">Submit Quiz</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let questionIndex = 0;

            // Add initial question and choice elements
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
                    <button type="button" class="delete-question">Delete Question</button>
                    <div class="choices">
                        <div class="choice">
                            <input type="text" name="questions[${questionIndex}][choices][0][text]" required>
                            <label>Correct:</label>
                            <input type="checkbox" name="questions[${questionIndex}][choices][0][is_correct]">
                            <button type="button" class="delete-choice">Delete Choice</button>
                        </div>
                    </div>
                    <button type="button" class="add-choice">Add Choice</button>
                `;

                // Attach events for deleting questions and choices
                questionContainer.querySelector('.delete-question').addEventListener('click', function() {
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
                    <button type="button" class="delete-choice">Delete Choice</button>
                `;

                choiceElement.querySelector('.delete-choice').addEventListener('click', function() {
                    this.closest('.choice').remove();
                });

                choicesContainer.appendChild(choiceElement);
            }

            document.addEventListener('click', (event) => {
                if (event.target && event.target.classList.contains('delete-question')) {
                    event.target.closest('.question').remove();
                }

                if (event.target && event.target.classList.contains('delete-choice')) {
                    event.target.closest('.choice').remove();
                }
            });
        });
    </script>
</body>
</html>
