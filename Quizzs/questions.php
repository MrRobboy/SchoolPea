<?php
include "database.php";
session_start();

// Set question number
$number = (int)$_GET['n'];

// Get total number of questions
$query = "SELECT COUNT(*) AS total FROM questions";
$stmt = $pdo->prepare($query);
$stmt->execute();
$total = $stmt->fetchColumn();

// Get Question
$query = "SELECT * FROM questions WHERE question_number = :number";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':number', $number, PDO::PARAM_INT);
$stmt->execute();
$question = $stmt->fetch(PDO::FETCH_ASSOC);

// Get Choices
$query = "SELECT * FROM choices WHERE question_number = :number";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':number', $number, PDO::PARAM_INT);
$stmt->execute();
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="current">Question <?php echo $number; ?> of <?php echo $total; ?></div>
	<p class="question">
	   <?php echo $question['question'] ?>
	</p>
	<form method="post" action="process.php">
	      <ul class="choices">
	        <?php while($row=$choices->fetch_assoc()): ?>
		<li><input name="choice" type="radio" value="<?php echo $row['id']; ?>" />
		  <?php echo $row['choice']; ?>
		</li>
		<?php endwhile; ?>
	      </ul>
	      <input type="submit" value="submit" />
	      <input type="hidden" name="number" value="<?php echo $number; ?>" />
	</form>
      </div>
    </div>
    </main>


    <footer>
      <div class="container">
      	   Copyright &copy; 2015, PHP Quizzer
      </div>
    </footer>
  </body>
</html>