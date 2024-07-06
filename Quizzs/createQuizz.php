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
        select {
            width: 100%;
            padding: 0.7em;
            margin-bottom: 1.5em;
            border: 1px solid #ccc;
            border-radius: 1em;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }
        input[type="submit"], button {
            background-color: #1e90ff; 
            color: white;
            padding: 0.7em 2.5em;
            border: none;
            border-radius: 1.5em; 
            cursor: pointer;
            font-weight: 600;
            font-size: 1em;
            margin-right: 1em;
        }
        input[type="submit"]:hover, button:hover {
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
        .choice {
            background-color: #f0f0f0;
            margin-bottom: 0.5em;
            padding: 0.5em;
            border: 1px solid #ccc;
            border-radius: 0.5em;
        }
        .choice input[type="text"] {
            width: calc(100% - 2.5em);
            padding: 0.3em;
            margin-bottom: 0.5em;
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
            font-size: 0.9em;
            margin-top: 0.5em;
        }
        .effacer-btn:hover {
            background-color: #d32f2f;
        }

        .container {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    color: #333;
}

p {
    font-size: 1.2rem;
    margin-bottom: 15px;
    line-height: 1.8;
}

.buttons {
    display: flex;
    justify-content: center;
    /* Centre les boutons horizontalement */
    margin-top: 20px;
    /* Espacement en haut des boutons */
}

.button-form {
    margin-right: 10px;
    /* Espacement entre le bouton "Rejouer le Quiz" et les autres boutons */
}

.button {
    display: inline-block;
    background-color: #5c6bc0;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 20px;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #3f51b5;
}

h3 {
    font-size: 2rem;
    margin-top: 30px;
    margin-bottom: 15px;
    color: #555;
}

/* Styles spécifiques pour le quiz */
.quiz-title {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #333;
}

.question-number {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: #555;
    font-weight: bold;
}

.question {
    font-size: 2rem;
    margin-bottom: 20px;
    color: #333;
}

.answers {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.answer {
    margin-bottom: 20px;
}

.answer button {
    background-color: #5c6bc0;
    color: white;
    border: none;
    padding: 15px 30px;
    text-align: center;
    font-size: 1.2rem;
    cursor: pointer;
    border-radius: 20px;
    transition: background-color 0.3s;
}

.answer button:hover {
    background-color: #3f51b5;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Crée un nouveau Quiz</h2>
        <form action="submitQuizz.php" method="post" enctype="multipart/form-data" id="quiz-form">
            <label for="quiz-name">Nom du Quiz:</label>
            <input type="text" name="quiz_name" id="quiz-name" required>

            <label for="quiz-description">Description:</label>
            <textarea name="quiz_description" id="quiz-description" required></textarea>

            <label for="quiz-image">Image de Présentation:</label>
            <input type="file" name="quiz_image" id="quiz-image" accept="image/*">

            <div id="questions-container">
            </div>
            
            <button type="button" id="add-question">Ajouter une  Question</button>
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
                    <button type="button" class="effacer-btn effacer-question">effacer Question</button>
                    <div class="choices">
                        <div class="choice">
                            <input type="text" name="questions[${questionIndex}][choices][0][text]" required>
                            <label>Correct:</label>
                            <input type="checkbox" name="questions[${questionIndex}][choices][0][is_correct]">
                            <button type="button" class="effacer-btn effacer-choice">effacer Choice</button>
                        </div>
                    </div>
                    <button type="button" class="add-choice">Add Choice</button>
                `;

                // Attach events for deleting questions and choices
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
                    <button type="button" class="effacer-btn effacer-choice">effacer Choice</button>
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
