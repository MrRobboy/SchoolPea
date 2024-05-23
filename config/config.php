<?php
//**configuration */
ini_set('display_errors', 'on');
error_reporting(E_ALL);

class MyAutoLoad
{
    public static function start()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));

        $root = $_SERVER['DOCUMENT_ROOT'];
        $host = $_SERVER['HTTP_HOST'];

        define('HOST', 'https://' . $host . '/SchoolPea/');
        define('ROOT', $root . 'SchoolPea/');

        define('MODEL', ROOT . 'app/model/');
        define('VIEW', ROOT . 'app/view/');
        define('CONTROLLER', ROOT . 'app/controller/');

        define('CONFIG', HOST . 'config/');
        define('PUBLIC', HOST . 'public/');
        define('CORE', HOST . 'core/');

        define('IMAGES', HOST . 'public/images/');
        define('CSS', HOST . 'public/css/');
        define('JS', HOST . 'public/js/');
    }

    public static function autoload($class)
    {
        if (file_exists(MODEL . $class . '.php')) {
            include_once(MODEL . $class . '.php');
        } elseif (file_exists(CORE . $class . '.php')) {
            include_once(CORE . $class . '.php');
        } elseif (file_exists(CONTROLLER . $class . '.php')) {
            include_once(CONTROLLER . $class . '.php');
        }
    }
}

// Start l'autoloader
MyAutoLoad::start();
?>
