
<?php

session_start();

include_once('config.php');

MyAutoLoad::start();

$request = $_GET['r ']; //index.php?r...

$routeur = new routeur ($request);
$routeur->renderController();
