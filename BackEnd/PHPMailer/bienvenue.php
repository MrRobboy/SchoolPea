<?php
include_once('fonctions.php');

$s = 'Bienvenue !';
$m = 'Nous vous accueillons chaleuresement sur Schoolpéa.<br>';
$m .= 'En espérant que vous vous amusiez le plus possible !'; //$m .= veut dire de le mettre à la suite !
echo ($m);
sendmail($s, $m, 'mail@mail.fr');
header('Location: ../Inscription-Connextion/confirmation_inscription.html');
