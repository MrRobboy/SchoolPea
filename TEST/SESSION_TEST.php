<?php
session_start();
if ($_SESSION['x'] == 5) include_once('./headerL.php');
else include_once('./headerNL.php');
