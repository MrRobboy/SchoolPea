<?php
session_start();
echo $_SESSION['email'] . '<br>';
include('db.php');
echo (htmlspecialchars($_POST['code']) . '<br>' . $_SESSION['verif']);
if (isset($_POST['submit'])) {
	if (htmlspecialchars($_POST['code']) == $_SESSION['verif']) {
		echo ('<br>code reussi !!');
		$queryStatement = $dbh->prepare('USE PA; UPDATE USER SET validation_mail=1 WHERE email =:email;');
		$queryStatement->bindvalue(':email', $_SESSION['email']);
		$result = $queryStatement->execute();
		$_SESSION['mail_valide'] = true;
		header('location: https://schoolpea.com/Connexion');
	} else {
		echo ('<br>code echoué :(');
		header('location: ./message_verification.php');
	}
} else {
	echo ('ERREUR SUBMIT');
	header('location: https://schoolpea.com');
}
