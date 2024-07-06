<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Additional style for the form */
        label {
            margin-top: 10px;
            display: block;
            font-weight: 500;
        }

        textarea,
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .choices {
            margin-top: 10px;
        }

        .choice {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .choice input[type="text"],
        .choice input[type="checkbox"] {
            margin-right: 6px;
        }

        .delete-choice {
            margin-left: auto;
            background-color: #f44336;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .delete-choice:hover {
            background-color: #cc0000;
        }

        .add-choice {
            margin-top: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .add-choice:hover {
            background-color: #45a049;
        }
    </style>
</head>
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
            
            <button type="button" id="add-question" class="button">Add Question</button>
            <button type="submit" class="button">Submit Quiz</button>
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
                    <div class="choices">
                        <div class="choice">
                            <input type="text" name="questions[${questionIndex}][choices][0][text]" required>
                            <label>Correct:</label>
                            <input type="checkbox" name="questions[${questionIndex}][choices][0][is_correct]">
                            <button type="button" class="remove-btn delete-choice">Delete Choice</button>
                        </div>
                    </div>
                    <button type="button" class="remove-btn delete-question">Delete Question</button>
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
                    <button type="button" class="remove-btn delete-choice">Delete Choice</button>
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
