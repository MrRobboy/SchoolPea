<?php include "database.php"; ?>

<?php
    //Get the total questions
    $query = "SELECT * FROM questions";
    
    // Get Results
    try {
        $stmt = $pdo->query($query);
        $total = $stmt->rowCount();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>PHP Quizzer!</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="container">
    <header>
        <div class="container">
            <h1>PHP Quizzer</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>Test your PHP Knowledge</h2>
            <p>This is a multiple choice quiz to test your knowledge about something</p>
            <ul>
                <li><strong>Number of Questions: </strong><?php echo $total; ?></li>
                <li><strong>Type: </strong>Multiple Choice</li>
                <li><strong>Estimated Time: </strong><?php echo $total * 0.5; ?> minutes</li>
            </ul>
            <a href="question.php?n=1" class="start">Start Quiz</a>
        </div>
    </main>

    <footer>
        <div class="container">
            Copyright &copy; 2015, PHP Quizzer
        </div>
    </footer>
</div>
</body>
</html>
