<?php
if ($_SESSION['role'] != "admin") {
    header('Location: https://schoolpea.com');
}
