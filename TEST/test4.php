<?php
session_start();
$_SESSION['start'] = time();
$x = 5;
if ($x >= 5) {
    include_once('./headerL.php');
    include_once('./test2.php'); /*Include c'est pour l'inclure, s'il ne trouve pas il va continuer à exécuter le code.
Require force la présence de ce qui est dans le chemin sinon il n'execute pas le code*/
} else {
    include_once('./headerNL.php');
    include_once('./test3.php');
}
echo 'Fin des conneries';
$_SESSION['x'] = $x;
$six_digit_random_number = random_int(100000, 999999); /*Valeur aléatoire à 6 chiffres*/
?>
<br>
<a href="./SESSION_TEST.php">TEST1212</a>