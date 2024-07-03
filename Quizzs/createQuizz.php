<?php
include 'common.php';
// createQuizz.php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <link rel="stylesheet" href="style.css">
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
                <div class="question" data-question-index="0">
                    <label>Question:</label>
                    <textarea name="questions[0][text]" required></textarea>
                    <div class="choices">
                        <div class="choice" data-choice-index="0">
                            <label>Choice:</label>
                            <input type="text" name="questions[0][choices][0][text]" required>
                            <label>Correct:</label>
                            <input type="checkbox" name="questions[0][choices][0][is_correct]">
                        </div>
                    </div>
                    <button type="button" class="add-choice">Add Choice</button>
                </div>
            </div>
            <button type="button" id="add-question">Add Question</button>
            <button type="submit">Submit Quiz</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
