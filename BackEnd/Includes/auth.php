<?php
if ($_SESSION['role'] != "admin") {
    echo ('<pre>');
    print_r($_SESSION);
    echo ('</pre>');
    // header('Location: https://schoolpea.com');
}
