<?php
include 'common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quizName = $_POST['quiz_name'];
    $quizDescription = $_POST['quiz_description'];

    // Handle file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["quiz_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["quiz_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
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
    // if everything is ok, try to upload file
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
    foreach ($_POST['questions'] as $question) {
        $questionText = $question['text'];
        $sql = "INSERT INTO QUESTIONS (id_quizz, question_text) VALUES (:quiz_id, :question_text)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':quiz_id', $quizId);
        $stmt->bindParam(':question_text', $questionText);
        $stmt->execute();
        $questionId = $dbh->lastInsertId();

        foreach ($question['choices'] as $choiceIndex => $choice) {
            $isCorrect = isset($choice['is_correct']) ? 1 : 0;
            $sql = "INSERT INTO CHOIX (id_question, choix_text, is_correct) VALUES (?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$questionId, $choice['text'], $isCorrect]);
        }
    }

    echo "Quiz created successfully!";
}
?>
