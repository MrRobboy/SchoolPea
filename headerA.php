<?php
session_start();
?>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="https://schoolpea.com/header.css" />
</head>

<header class="admin">
	<div id="accueil">
		<a href="#SchoolPea">
			<img id="logo_header" src="https://schoolpea.com/Images/SchoolPea.png" />
		</a>
		<a href="#SchoolPea"> SchoolPéa </a>
	</div>

	<div id="Pages">
		<span>
			<a class="lien_header" href="https://schoolpea.com/SchoolPea+/"> SchoolPea+ </a>
		</span>

		<span>
			<a class="lien_header" href="https://schoolpea.com/Quizzs/">
				Explorer les Quizzs
			</a>
		</span>

		<span>
			<a class="lien_header" href="https://schoolpea.com/Cours/">
				Explorer les Cours
			</a>
		</span>

		<span>
			<a class="lien_header" href="https://schoolpea.com/Backend/">
				Back-office
			</a>
		</span>

		<span id="slide_down">
			<img src="https://schoolpea.com/Images/liste.svg" id="dropbtn">
			<div id="dropdown">
				<a class="lien_header">Voir Plus</a>
				<a class="lien_header">Mon compte</a>
				<a class="lien_header">Paramètres</a>
			</div>
		</span>

		<span style="margin-left: 1.2rem">
			<img src="<?php echo ($_SERVER['DOCUMENT_ROOT'] . $_SESSION['pp_path']); ?>" id="Photo_profile" /> <!-- Aller chercher la photo de profile lié à l'utilisateur -->
		</span>
	</div>
</header>