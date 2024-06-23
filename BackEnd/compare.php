<?php
session_start();
echo $_SESSION['email'] . '<br>';
include('db.php');
echo ($_POST['code'] . '<br>' . $_SESSION['verif']);
if (isset($_POST['submit'])) {
	if ($_POST['code'] == $_SESSION['verif']) {
		echo ('<br>code reussi !!');
		$queryStatement = $dbh->prepare('USE PA; UPDATE USER SET validation_mail=1 WHERE email =:email;');
		$queryStatement->bindvalue(':email', $_SESSION['email']);
		$result = $queryStatement->execute();
		$queryStatement = $dbh->query('SELECT id FROM USER WHERE email=:email;');
		$queryStatement->bindvalue(':email', $_SESSION['email']);
		$result = $queryStatement->fetchAll();
		$_SESSION['id'] = $result[0]['id'];
		echo $_SESSION['id'];
		// header('location: captcha.php');
	} else {
		echo ('<br>code echoué :(');
		// header('location: ./message_verification.php');
	}
} else {
	echo ('ERREUR SUBMIT');
	// header('location: ' . $_SERVER['DOCUMENT_ROOT']);
	echo ($_POST['submit']);
}
