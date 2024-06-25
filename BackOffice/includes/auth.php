<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function checkRole($role)
{
    return isLoggedIn() && $_SESSION['role'] == $role;
}

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
