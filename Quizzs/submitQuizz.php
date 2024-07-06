<?php
include 'common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
    echo "</pre>";

    $quizName = isset($_POST['quiz_name']) ? $_POST['quiz_name'] : null;
    $quizDescription = isset($_POST['quiz_description']) ? $_POST['quiz_description'] : null;
    $quizImage = isset($_FILES['quiz_image']) ? $_FILES['quiz_image'] : null;

    // Check required fields
    if ($quizName === null) {
        echo "Quiz name is required.";
        exit;
    }

    if ($quizDescription === null) {
        echo "Quiz description is required.";
        exit;
    }

    if ($quizImage !== null) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($quizImage["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($quizImage["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($quizImage["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($quizImage["tmp_name"], $targetFile)) {
                $target_storage = $targetFile;
                echo "The file " . htmlspecialchars(basename($quizImage["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            $target_storage = null;
        }
    } else {
        $target_storage = null;
    }

    // SQL to insert quiz details
    $sql = "INSERT INTO QUIZZ (nom, description, path_img_pres, date_creation) VALUES (?, ?, ?, NOW())";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$quizName, $quizDescription, $target_storage]);

    $quizId = $dbh->lastInsertId();

    // Insert questions and choices
    foreach ($_POST['questions'] as $questionIndex => $question) {
        if (isset($question['text']) && !empty($question['text'])) {
            $sql = "INSERT INTO QUESTIONS (id_quizz, question_text) VALUES (?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$quizId, $question['text']]);

            $questionId = $dbh->lastInsertId();

            foreach ($question['answers'] as $choiceIndex => $choice) {
                if (isset($choice['text']) && !empty($choice['text'])) {
                    $isCorrect = isset($choice['is_correct']) ? 1 : 0;
                    $sql = "INSERT INTO CHOIX (id_question, choix_text, is_correct) VALUES (?, ?, ?)";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute([$questionId, $choice['text'], $isCorrect]);
                }
            }
        }
    }

    echo "Quiz created successfully!";
}
?>
