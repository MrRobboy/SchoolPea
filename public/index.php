
<?php
include_once(CONFIG.'config.php');

MyAutoLoad::start();

$request = $_GET['r ']; //index.php?r...

$routeur = new routeur ($request);
$routeur->renderController();
