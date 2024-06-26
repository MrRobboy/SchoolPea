<?php
session_start();
if (!empty($_SESSION['mail_valide']) && $_SESSION['mail_valide'] == true) {
	echo '<script>alert("Votre mail a bien été enregisté")</script>';
}
session_unset();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion | SchoolPéa</title>
	<link rel="stylesheet" type="text/css" href="./connexion.css">
</head>

<body>
	<div class="container Connexion" id="Conteneur">
		<div class="form-container sign-in">
			<form action="connexion.php" method="post">
				<h1>Connexion</h1>
				<?php
				/*if (isset($badCredentials) && $badCredentials) {
					echo ('<p class="error">Mauvais identifiants</p>');
				}*/
				?>
				<input type="email" id="email" name="email_connexion" placeholder="Email" required>
				<input type="password" id="password" name="password_connexion" placeholder="Mot de passe" required>
				<a href="#">Mot de passe oublié ?</a>
				<button type="submit" name="submit_connexion">Connexion</button>
			</form>
		</div>

		<div class="form-container sign-up">
			<form action="../../BackEnd/inscription.php" method="post">
				<h1 style="text-align: center">Bienvenue chez SchoolPéa</h1>
				<?php /*
				if (isset($_GET['error']) && $_GET['password'] === '0') {
					echo ('<p>Un champ a mal été saisi</p>');
				}*/
				?>
				<input type="text" name="lastname" placeholder="Nom" required>
				<input type="text" name="firstname" placeholder="Prenom" required>
				<input type="email" name="email_inscription" placeholder="Email" required>
				<input type="password" name="password_inscription" placeholder="Mot de passe" required>
				<button type="submit" name="submit_inscription">Inscription</button>
			</form>
		</div>

		<div class="toggle-container">
			<div class="toggle">
				<div class="toggle-panel toggle-left">
					<h1>Te revoilà !</h1>
					<button class="hidden" id="Connexion">Connexion</button>
				</div>
				<div class="toggle-panel toggle-right">
					<h1>T'es nouveau ?</h1>
					<button class="hidden" id="Inscription">Inscription</button>
				</div>
			</div>
		</div>
	</div>
	<script src="./script_Inscr_Conn.js"></script>
</body>

</html>