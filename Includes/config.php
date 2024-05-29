<?php
//**configuration */
ini_set('display_errors', 'on');
error_reporting(E_ALL);


        $root = $_SERVER['DOCUMENT_ROOT'];
        $host = $_SERVER['HTTP_HOST'];

        define('HOST', 'https://' . $host . '/SchoolPea/');
        define('ROOT', $root . '/SchoolPea/');

        define('BACKEND', ROOT . 'BackEnd');
        define('BACKOFFICE', ROOT . 'BackOffice/');
        

        define('IMAGES', HOST . 'FrontEnd/Images/');
        define('INCLUDES', ROOT . 'Includes/');
        define('PAGES', HOST . 'FrontEnd/Pages/');

        define('SCRIPTS', HOST . 'FrontEnd/Scripts/');
        define('STYLES', HOST . 'FrontEnd/Styles');

