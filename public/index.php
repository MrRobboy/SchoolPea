<?php
include_once('_config.php');

$request = $_GET['r']; //index.php?r...
if($request == "accueil")
{
include_once(CONTROLLERS./'Accueil (non-connecté)/accueil.php');
}else{
    include(PUBLIC./'error404.php');
}
?>
