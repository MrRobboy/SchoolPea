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
		if ($result) {
			$queryUser = $dbh->prepare('SELECT id_USER FROM USER WHERE email = :email');
			$queryUser->bindValue(':email', $_SESSION['email']);
			$user_found = $queryUser->fetchAll();
			if ($user_found) {
				$message = $_SESSION['email'] . ' a été validé par l\'utilisateur n°' . $id_USER;
				$queryLogs = $dbh->prepare('USE PA; INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg);');
				$queryLogs->bindvalue(':id_USER', $id_USER);
				$queryLogs->bindvalue(':msg', $message);
				$result2 = $queryLogs->execute();
				echo ('<br>code reussi !!');
				if ($result2) {
					$_SESSION['mail_valide'] = true;
					header('location: https://schoolpea.com/Connexion');
				} else echo 'Erreur logs';
			}
		}
	} else {
		echo ('<br>code echoué :(');
		header('location: ./message_verification.php');
	}
} else {
	echo ('ERREUR SUBMIT');
	header('location: https://schoolpea.com');
}
