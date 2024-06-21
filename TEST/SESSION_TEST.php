<?php
session_start();
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 60)) {
        if ($_SESSION['x'] < 5) {
                header('location: ./test2.php');
        }
        if ($_SESSION['x'] == 5) include_once('../headerL.php');
        else include_once('../headerNL.php');
}

echo ($_SESSION['start']);
echo ('<br>' . time());
