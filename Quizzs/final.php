<?php include "database.php"; ?>
<?php session_start(); ?>
<?php
// Création de la requête SELECT avec PDO
$query = "SELECT * FROM shouts ORDER BY time DESC LIMIT 100";
$stmt = $pdo->prepare($query);
$stmt->execute();
$shouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
	     <h2>You are Done!</h2>
	     <p>Congrats! You have completed the test</p>
	     <p>Final socre: <?php echo $_SESSION['score']; ?></p>
	     <a href="question.php?n=1" class="start">Take Test Again</a>
	     <?php session_destroy(); ?>
	</div>
      </main>


    <footer>
      <div class="container">
      	   Copyright &copy; 2015, PHP Quizzer
      </div>
    </footer>
  </body>
</html>