<?php
session_start();
include('db.php');
echo ('question n° :' . $_SESSION['x']);
$request = $dbh->query('SELECT reponse1, reponse2, reponse3, reponse4, reponse5 FROM CAPTCHA where id=' . $_SESSION['x'] . ';');
$reponses = $request->fetchAll();

if (!empty($_POST['submit'])) {
    if (!verify($_POST['textCaptchaAnswer'], $reponses)) {
        $_SESSION['erreur'] = 'erreur';
        echo ($_POST['textCaptchaAnswer'] . '<br>' . $_SESSION['erreur']);
        // header('location: captcha.php');
    } else {
        echo ($_POST['textCaptchaAnswer'] . '<br>' . $_SESSION['erreur']);
        unset($_SESSION['erreur']);
        echo ($_POST['textCaptchaAnswer'] . '<br>' . $_SESSION['erreur']);
        // header('location: ./message_verification.php');
    }
}
// else header('location: captcha.php');

function verify($Answer_user, $Tab_Reponses)
{
    $Answer_user = stripslashes($Answer_user);
    for ($index = 1; $index <= 5; $index++) $Tab_Answers[$index] = stripslashes($Tab_Reponses[0]['reponse' . $index]);
    $result = false;
    foreach ($Tab_Answers as $TA) if (strcasecmp(trim($Answer_user), trim($TA)) == 0) $result = true;
    if ($result) echo ('REUSSITE');
    else echo ('resultat : ECHEC<br>');
    echo ('<pre>');
    print_r($Tab_Answers);
    echo ('</pre>');
    return $result;
}
