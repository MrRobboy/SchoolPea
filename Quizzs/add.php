<?php include "database.php"; ?>

<?php
if (isset($_POST['submit'])) {
    // Récupérer les variables POST
    $question_number = $_POST['question_number'];
    $question_text = $_POST['question_text'];
    $correct_choice = $_POST['correct_choice'];
    $choices = array();
    $choices[1] = $_POST['choice1'];
    $choices[2] = $_POST['choice2'];
    $choices[3] = $_POST['choice3'];
    $choices[4] = $_POST['choice4'];
    $choices[5] = $_POST['choice5'];

    // Requête d'insertion pour la question
    $query = "INSERT INTO questions (question_number, question) VALUES (:question_number, :question_text)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':question_number', $question_number, PDO::PARAM_INT);
    $stmt->bindParam(':question_text', $question_text, PDO::PARAM_STR);
    $stmt->execute();

    // Validation de l'insertion de la question
    if ($stmt->rowCount() > 0) {
        // Boucle pour insérer les choix
        foreach ($choices as $choice => $value) {
            if (!empty($value)) {
                $is_correct = ($correct_choice == $choice) ? 1 : 0;

                // Requête d'insertion pour les choix
                $query = "INSERT INTO choices (question_number, is_correct, choice) VALUES (:question_number, :is_correct, :choice)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':question_number', $question_number, PDO::PARAM_INT);
                $stmt->bindParam(':is_correct', $is_correct, PDO::PARAM_INT);
                $stmt->bindParam(':choice', $value, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
        $msg = "Question ajoutée avec succès";
    } else {
        die("Erreur lors de l'insertion de la question");
    }
}

// Obtenir le nombre total de questions
$query = "SELECT * FROM questions";
$stmt = $pdo->prepare($query);
$stmt->execute();
$total = $stmt->rowCount();
$next = $total + 1;
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
	     <h2>Add A question</h2>
	     <?php 
	     	   if(isset($msg)) {
	     	      echo "<p>".$msg."</p>";
	     }
	     ?>
	     <form method="post" action="add.php">
	     	   <p>
			<label>Question Number</label>
			<input type="number" value="<?php echo $next; ?>" name="question_number" />
		   </p>
	     	   <p>
			<label>Question</label>
			<input type="text" name="question_text" />
		   </p>
	     	   <p>
			<label>Choice #1: </label>
			<input type="text" name="choice1" />
		   </p>
	     	   <p>
			<label>Choice #2: </label>
			<input type="text" name="choice2" />
		   </p>
	     	   <p>
			<label>Choice #3: </label>
			<input type="text" name="choice3" />
		   </p>
	     	   <p>
			<label>Choice #4: </label>
			<input type="text" name="choice4" />
		   </p>
	     	   <p>
			<label>Choice #5: </label>
			<input type="text" name="choice5" />
		   </p>
	     	   <p>
			<label>Correct choice number </label>
			<input type="number" name="correct_choice" />
		   </p>
		   <p>
			<input type="submit" name="submit" value="Submit" />
		   </p>
	     </form>
	</div>
      </main>


    <footer>
      <div class="container">
      	   Copyright &copy; 2015, PHP Quizzer
      </div>
    </footer>
  </body>
</html>