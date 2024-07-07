<?php
session_start();
$badCredentials = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['password_connexion']) || !isset($_POST['email_connexion'])) {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
} else header('Location: ' . $_SERVER['HTTP_REFERER']);

$pass = htmlspecialchars($_POST['password_connexion']);
$email = htmlspecialchars($_POST['email_connexion']);

include('db.php');
$dbh->exec('USE PA');
$requestDB = 'SELECT * FROM USER where email ="' . $email . '";';
$UserInfo = $dbh->query($requestDB);
$user = $UserInfo->fetchAll();

echo '<pre>';
print_r($user);
echo '</pre>';

if (!empty($user) && $user[0]['validation_mail'] == 1) {
	echo 'test1<br>';
	echo $pass;
	echo '<br>' . $user[0]['pass'];
	if (password_verify($pass, $user[0]['pass'])) {
		$_SESSION['id_user'] = htmlspecialchars($user[0]['id_USER']);
		$_SESSION['email'] = htmlspecialchars($user[0]['email']);
		$_SESSION['firstname'] = htmlspecialchars($user[0]['firstname']);
		$_SESSION['lastname'] = htmlspecialchars($user[0]['lastname']);
		$_SESSION['path_pp'] = htmlspecialchars($user[0]['path_pp']);
		$_SESSION['elo'] = htmlspecialchars($user[0]['elo']);
		$_SESSION['role'] = htmlspecialchars($user[0]['role']);
		$_SESSION['mail_valide'] = htmlspecialchars($user[0]['validation_mail']);

		$message = $_SESSION['id_user'] . ' - ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' s\'est connecté';

		$queryLogs = $dbh->prepare('INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg);');
		$queryLogs->bindvalue(':id_USER', $user[0]['id_USER']);
		$queryLogs->bindvalue(':msg', $message);
		$result = $queryLogs->execute();

		if ($result) {
			header('Location: https://schoolpea.com');
		}
		echo ('ERREUR');
	} else $badCredentials = true;
} else echo ('Mail non validé !!!!');

if ($badCredentials == true) {
	echo "Invalid email or password.";
}
