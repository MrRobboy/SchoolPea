<?php

$CQs = array(
    array("Qui a découvert l'Amérique ? ", "Christophe Colomb", "Cristophe Colomb", "Colomb", "C.Colomb", "C Colomb"),
    array("Quand a eu lieu la Révolution française ? ", "1789"),
    array("Où a eu lieu la Première Guerre mondiale ? (Continent) ", "En Europe", "Europe", "Eu"),
    array("Qui a été le premier homme sur la Lune ? ", "Neil Armstrong", "Niel Amstrong", "Niel Armstrong", "Neil Amstrong", "N.A."),
    array("Quand a eu lieu la chute du mur de Berlin ? ", "1989", "89"),
    array("4 + 4 ? ", "8"),
    array("12 - 5 ? ", "7"),
    array("3 * 5 ? ", "15"),
    array("16 / 2 ? ", " 8"),
    array("2 ^ 3 ? ", " 8"),
); /*A retirer une fois connecté à la BDD*/

if (!empty($_POST['submit'])) {
    if (verify($_POST['textCaptchaAnswer'], $CQs[0])) header('location: ../Accueil/index.html'); /* Plus qu'à connecter avec la bdd, */
    else header('location: ./Captcha.php');
} else header('location: ./Captcha.php');

function verify($Answer_user, $Tab_Reponses)
{
    $Answer_user = stripslashes($Answer_user);
    for ($index = 1; $index < count($Tab_Reponses); $index++) $Tab_Answers[$index - 1] = stripslashes($Tab_Reponses[$index]);
    $result = false;
    foreach ($Tab_Answers as $TA) if (strcasecmp(trim($Answer_user), trim($TA)) == 0) $result = true;
    return $result;
}
