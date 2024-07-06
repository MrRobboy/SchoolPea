<?php
session_start();
$badCredentials = false;

$pass = htmlspecialchars($_POST['old_pass']);
$email = htmlspecialchars($_SESSION['email']);

$_POST;
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/BackEnd/db.php';
include($path);

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
                if ($_POST['new_pass'] == $_POST['confirm_new_pass']) {
                        $message = $_SESSION['id_user'] . ' - ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' A changé son mdp';

                        $queryLogs = $dbh->prepare('INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg)');
                        $queryLogs->bindvalue(':id_USER', $user[0]['id_USER']);
                        $queryLogs->bindvalue(':msg', $message);
                        $result = $queryLogs->execute();

                        $Change_pass = $dbh->prepare('UPDATE USER SET pass=:pass where email=:email');
                        $Change_pass->bindvalue(':pass', password_hash($_POST['new_pass'], PASSWORD_DEFAULT));
                        $Change_pass->bindvalue(':email', $_SESSION['email']);
                        $resultPass = $Change_pass->execute();

                        if ($resultPass) {
                                echo 'MDP CHANGEE AVEC SUCCES';
                                header('Location: https://schoolpea.com/Compte/index.php?success=1');
                        }
                } else {
                        echo ('<br>Les nouveau mot de passes ne sont pas bons !');
                        header('Location: https://schoolpea.com/Compte/index.php?error_mdp=1');
                }
        } else {
                $badCredentials = true;
                echo '<br>triche';
                header('Location: https://schoolpea.com/Compte/index.php?error_mdp=1');
        }
} else echo ('Mail non validé !!!!');

if ($badCredentials == true) {
        echo "<br>Invalid email or password.";
        $message = $_SESSION['id_user'] . ' - ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' A tenté de changer le mdp';

        $queryLogs2 = $dbh->prepare('INSERT INTO LOGS(id_user, act) VALUES (:id_USER,:msg);');
        $queryLogs2->bindvalue(':id_USER', $user[0]['id_USER']);
        $queryLogs2->bindvalue(':msg', $message);
        $result2 = $queryLogs2->execute();
}
