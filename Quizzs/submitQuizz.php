<?php
session_start();
include 'common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['mail_valide'])) {
    $quizName = $_POST['quiz_name'];
    $quizDescription = $_POST['quiz_description'];
    $questions = $_POST['questions'];

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["quiz_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
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
        if (move_uploaded_file($_FILES["quiz_image"]["tmp_name"], $target_file)) {
            $stmt = $dbh->prepare("INSERT INTO QUIZZ (nom, description, path_img_pres, date_creation) VALUES (:nom, :description, :path_img_pres, NOW())");
            $stmt->bindParam(':nom', $quizName);
            $stmt->bindParam(':description', $quizDescription);
            $stmt->bindParam(':path_img_pres', $target_file);
            $stmt->execute();
            $quizId = $dbh->lastInsertId();

            foreach ($questions as $question) {
                $stmt = $dbh->prepare("INSERT INTO QUESTIONS (id_quizz, question_text) VALUES (:id_quizz, :question_text)");
                $stmt->bindParam(':id_quizz', $quizId);
                $stmt->bindParam(':question_text', $question['text']);
                $stmt->execute();
                $questionId = $dbh->lastInsertId();

                foreach ($question['choices'] as $choice) {
                    $stmt = $dbh->prepare("INSERT INTO CHOIX (id_question, choix_text, is_correct) VALUES (:id_question, :choix_text, :is_correct)");
                    $stmt->bindParam(':id_question', $questionId);
                    $stmt->bindParam(':choix_text', $choice['text']);
                    $stmt->bindParam(':is_correct', $choice['is_correct'] ? 1 : 0);
                    $stmt->execute();
                }
            }

            header('Location: explorerLesQuizzs.php');
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "Invalid request or not authenticated.";
}
?>
