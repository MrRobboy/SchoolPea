<?php
session_start();
$x = 4;
if ($x == 5) {
    include_once('./headerL.php');
    include_once('./test2.php'); /*Include c'est pour l'inclure, s'il ne trouve pas il va continuer à exécuter le code.
    Require force la présence de ce qui est dans le chemin sinon il n'execute pas le code*/
} else {
    include_once('./test3.php');
    include_once('headerNL.php');
}
echo 'Fin des conneries';
$_SESSION['x'] = $x;
?>
<br>
<a href="./SESSION_TEST.php">TEST1212</a>