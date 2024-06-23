<?php
session_start();
echo $_SESSION['email'];

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

// shuffle($CQs); /*Sert pour prendre une question au hasard et le met en 1 er (c'est celui qu'on va afficher).*/
$question = stripslashes($CQs[0][0]); /*Dans les tableaux on a mis à chaque fois la question en premier, donc on prend le premier indice.*/

echo ('<form method="post" style="margin : 5rem auto; justify-content : center; display : flex; font-size: 1.5rem;" action="../../BackEnd/Verif_captcha.php" >' . $question);
echo ('<input name="textCaptchaAnswer" style="margin : 0 0.5rem; font-size : 1.5rem" type="text" required />');
echo ('<input type="submit" style ="padding: 0 0.5rem; font-size : 1rem;" value="Submit" name="submit"></form>');
