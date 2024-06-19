<?php
$x = 5;
if ($x == 5)
    include_once('./test.php'); /*Include c'est pour l'inclure, s'il ne trouve pas il va continuer à exécuter le code.
    Require force la présence de ce qui est dans le chemin sinon il n'execute pas le code*/
else include_once('./test3.php');
echo 'Fin des conneries';
