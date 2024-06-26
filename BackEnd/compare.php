<?php
session_start();
echo $_SESSION['email'] . '<br>';
include('db.php');
echo (htmlspecialchars($_POST['code']) . '<br>' . $_SESSION['verif']);
if (isset($_POST['submit'])) {
	if (htmlspecialchars($_POST['code']) == $_SESSION['verif']) {
		$dbh->exec('USE PA');
		echo ('<br>code reussi !!');
		$queryStatement = $dbh->prepare('UPDATE USER SET validation_mail=1 WHERE email =:email;');
		$queryStatement->bindvalue(':email', $_SESSION['email']);
		$result = $queryStatement->execute();
		if ($result) {
			$sqlRequest = 'SELECT id_USER FROM USER WHERE email =' . $_SESSION['email'];
			$queryUser = $dbh->query($sqlRequest);
			$queryUser->execute();
			$user_found = $queryUser->fetchAll();
			if ($user_found) {
				$message = $_SESSION['email'] . ' a été validé par l\'utilisateur n°' . $user_found;
				$queryLogs = $dbh->prepare('INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg);');
				$queryLogs->bindvalue(':id_USER', $user_found);
				$queryLogs->bindvalue(':msg', $message);
				$result2 = $queryLogs->execute();
				echo ('<br>code reussi !!');
				if ($result2) {
					$_SESSION['mail_valide'] = true;
					header('location: https://schoolpea.com/Connexion');
				} else echo 'Erreur logs';
			} else echo 'user_not_found';
		}
	} else {
		echo ('<br>code echoué :(');
		header('location: ./message_verification.php');
	}
} else {
	echo ('ERREUR SUBMIT');
	header('location: https://schoolpea.com');
}
