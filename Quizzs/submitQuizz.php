<?php
include 'common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quizName = $_POST['quiz_name'];
    $quizDescription = $_POST['quiz_description'];

    // Handle file upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["quiz_image"]["name"]);
    $targetFile = $targetDir . uniqid() . "_" . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["quiz_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["quiz_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["quiz_image"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["quiz_image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // SQL to insert quiz details
    $sql = "INSERT INTO QUIZZ (nom, description, path_img_pres, date_creation) VALUES (?, ?, ?, NOW())";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$quizName, $quizDescription, $targetFile]);

    $quizId = $dbh->lastInsertId();

    // Insert questions and choices
    foreach ($_POST['questions'] as $questionIndex => $question) {
        if (isset($question['text']) && !empty($question['text'])) {
            $sql = "INSERT INTO QUESTIONS (id_quizz, question_text) VALUES (?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$quizId, $question['text']]);

            $questionId = $dbh->lastInsertId();

            foreach ($question['choices'] as $choiceIndex => $choice) {
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
