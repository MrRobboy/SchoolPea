<?php
session_start();

if (empty($_SESSION['mail_envoyee'])) {
	header('Location: ./verification.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title>En attente de validation</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="./back.css">
</head>

<body>
	<div class="container">
		<div>
			<form action="./compare.php" method="post">
				<h1>Mail à valider !</h1>
				<p>Un code de validation à saisir vous a été envoyé à l'adresse suivante :</p>
				<p style="font-size: 20px; font-weight: 00;"><?php echo $_SESSION['email']; ?></p>
				<input type="text" name="code" style="font-size: 20px; font-weight: 400; background-color: #eee; border: solid 1px black;" required>
				<button type="submit" name="submit">Valider</button>
			</form>
		</div>
	</div>
</body>

</html>