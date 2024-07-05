<?php
include 'common.php';
?>

<!DOCTYPE html>
<html lang="fr">
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
                <!-- Placeholder for dynamic questions and choices -->
            </div>
            
            <button type="button" id="add-question">Add Question</button>
            <button type="submit">Submit Quiz</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
